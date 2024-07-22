<?php

namespace App\Http\Controllers;

use App\Exports\PelatihanInstrukturExport;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pelatihans;
use App\Models\RangeTanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\pelatihanInstruktur;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PelatihanController extends Controller
{

    // Instruktur

    // Cari Pelatihan
    // public function cariPelatihan()
    // {

    //     $currentMonth = date('m');
    //     $currentYear = date('Y');

    //     $pelatihans = Pelatihans::with('relasiDenganRangeTanggal')
    //         ->whereHas('relasiDenganRangeTanggal', function ($query) use ($currentMonth, $currentYear) {
    //             $query->whereMonth('tanggal_mulai', $currentMonth)
    //                 ->whereYear('tanggal_mulai', $currentYear);
    //         })
    //         ->get();

    //     $user = Auth::user();

    //     foreach ($pelatihans as $pelatihan) {
    //         $pelatihan->sudahBid = pelatihanInstruktur::where('id_pelatihan', $pelatihan->id)
    //             ->where('id_instruktur', $user->id)
    //             ->exists();
    //         $pelatihan->KuotaInstruktur = $pelatihan->kuota_instruktur <= 0;
    //     }

    //     return view('cari-pelatihan', ['pelatihans' => $pelatihans]);
    // }

    // Instruktur (Cari Pelatihan)
    public function cariPelatihan(Request $request)
    {
        $keyword = $request->input('keyword');

        $currentMonth = date('m');
        $currentYear = date('Y');

        $pelatihans = Pelatihans::with('relasiDenganRangeTanggal')
            ->where('nama', 'LIKE', '%' . $keyword . '%')
            ->orWhere('prl', 'LIKE', '%' . $keyword . '%')
            ->orWhere('lokasi', 'LIKE', '%' . $keyword . '%')
            ->orWhere('kuota_instruktur', 'LIKE', '%' . $keyword . '%')
            ->orWhere('kuota', 'LIKE', '%' . $keyword . '%')
            // ->whereHas('relasiDenganRangeTanggal', function ($query) use ($currentMonth, $currentYear) {
            //     $query->whereMonth('tanggal_mulai', $currentMonth)
            //         ->whereYear('tanggal_mulai', $currentYear);
            // })
            ->paginate(10);

        $user = Auth::user();

        foreach ($pelatihans as $pelatihan) {
            // Cek apakah instruktur sudah bid pada pelatihan ini
            $pelatihan->sudahBid = pelatihanInstruktur::where('id_pelatihan', $pelatihan->id)
                ->where('id_instruktur', $user->id)
                ->exists();

            // Hitung jumlah instruktur yang aktif (tidak dihapus)
            $activeInstructorsCount = pelatihanInstruktur::where('id_pelatihan', $pelatihan->id)
                ->whereNull('deleted_at')
                ->count();

            // Hitung jumlah instruktur yang dihapus
            $deletedInstructorsCount = pelatihanInstruktur::where('id_pelatihan', $pelatihan->id)
                ->whereNotNull('deleted_at')
                ->count();

            // Tambahkan ke kuota instruktur jika ada instruktur yang dihapus
            $pelatihan->KuotaInstruktur = ($pelatihan->kuota_instruktur - $activeInstructorsCount) + $deletedInstructorsCount;
        }

        // Cek flash message untuk notifikasi
        $message = session('status');

        return view('cari-pelatihan', [
            'pelatihans' => $pelatihans,
            'message' => $message
        ]);
    }



    public function deletePelatihan($id)
    {
        $pelatihan = Pelatihans::find($id);
        $pelatihan->delete();
        return redirect()->route('pelatihan')->with('success', 'Pelatihan berhasil dihapus');
    }


    // admin
    public function listingPelatihan()
    {
        // $pelatihans = Pelatihans::with('relasiDenganRangeTanggal', 'relasiDenganInstruktur.user')->get();
        // foreach ($pelatihans as $pelatihan) {
        //     foreach ($pelatihan->relasiDenganInstruktur as $instruktur) {
        //     }
        // }
        // return view('admin.pelatihan', ['pelatihans' => $pelatihans, 'instruktur' => $instruktur]);

        // Mengambil data pelatihan beserta relasi tanggal dan instruktur
        $pelatihans = Pelatihans::with(['relasiDenganRangeTanggal', 'relasiDenganInstruktur.user'])->paginate(10);
        return view('admin.pelatihan', compact('pelatihans'));
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->input('bulan');
        return Excel::download(new PelatihanInstrukturExport($bulan), 'data-pelatihan-bulan-' . Carbon::now()->month . '-' . Carbon::now()->timestamp . '.xlsx');
    }

    public function create()
    {
        return view('admin.input-pelatihan');
    }
    public function edit($id)
    {

        $pelatihan = Pelatihans::with('relasiDenganRangeTanggal')->findOrFail($id);

        if (!$pelatihan) {
            return redirect('pelatihan')->with('error', 'Pelatihan tidak ditemukan');
        }

        return view('admin.edit-pelatihan', ['pelatihan' => $pelatihan]);
    }

    public function update(Request $request, $id)
    {

        $pelatihan = Pelatihans::find($id);
        $request->validate([
            'KuotaInstruktur' => 'min:1|max:2',
            'TanggalMulai' => 'date',
            'TanggalAkhir' => 'date|after_or_equal:TanggalMulai'
        ]);

        // Check if the dates have been changed
        $tanggalMulaiLama = $pelatihan->relasiDenganRangeTanggal->tanggal_mulai;
        $tanggalAkhirLama = $pelatihan->relasiDenganRangeTanggal->tanggal_akhir;

        $tanggalMulaiBaru = $request->input('TanggalMulai');
        $tanggalAkhirBaru = $request->input('TanggalAkhir');

        // Jika tanggal mulai atau akhir berubah, hapus data di tabel pelatihan_instruktur yang terkait dengan id pelatihan
        if ($request->filled('TanggalMulai') && $request->filled('TanggalAkhir')) {
            if ($tanggalMulaiLama !== $tanggalMulaiBaru || $tanggalAkhirLama !== $tanggalAkhirBaru) {
                // Periksa apakah ada entri terkait di tabel pelatihan_instruktur
                $exists = DB::table('pelatihan_instruktur')->where('id_pelatihan', $id)->exists();
                if ($exists) {
                    DB::table('pelatihan_instruktur')->where('id_pelatihan', $id)->delete();
                }
            }
        }

        $pelatihan->nama = $request->input('nama');
        $pelatihan->prl = $request->input('PRL');
        $pelatihan->lokasi = $request->input('Lokasi');
        $pelatihan->kuota_instruktur = $request->input('KuotaInstruktur');
        $pelatihan->kuota = $request->input('Kuota');

        // Update tanggal mulai dan akhir
        if ($request->filled('TanggalMulai')) {
            $pelatihan->relasiDenganRangeTanggal->tanggal_mulai = $tanggalMulaiBaru;
        }
        if ($request->filled('TanggalAkhir')) {
            $pelatihan->relasiDenganRangeTanggal->tanggal_selesai = $tanggalAkhirBaru;
        }
        $pelatihan->relasiDenganRangeTanggal->save();

        // Simpan perubahan ke database
        $pelatihan->save();

        return redirect()->route('pelatihan')->with('success', 'Pelatihan berhasil Diperbarui!');
    }

    // Input Pelatihan Store
    public function store(Request $request)
    {
        $customMessage = [
            'Nama.required' => '*Nama pelatihan wajib diisi',
            'KuotaInstruktur.required' => '*Kuota instruktur wajib diisi',
            'KuotaInstruktur.min' => '*Kuota instruktur minimal 1',
            'KuotaInstruktur.max' => '*Kuota instruktur maksimal 2',
            'Kuota.required' => '*Kuota instruktur wajib diisi',
            'Kuota.min' => '*Kuota minimal 1',
            'Kuota.max' => '*Kuota maksimal 1000',
            'TanggalMulai.required' => '*Tanggal mulai pelatihan harus diisi',
            'TanggalAkhir.required' => '*Tanggal akhir pelatihan harus diisi'
        ];

        $request->validate([
            'Nama' => 'required|string|max:255',
            'PRL' => 'string|max:255',
            'Lokasi' => 'required|string|max:255',
            'KuotaInstruktur' => 'required|integer|min:1|max:2',
            'Kuota' => 'required|integer|min:1|max:1000',
            'TanggalMulai' => 'required|date',
            'TanggalAkhir' => 'required|date|after_or_equal:TanggalMulai',
        ], $customMessage);


        $range_tanggal = RangeTanggal::create([
            'tanggal_mulai' => $request->input('TanggalMulai'),
            'tanggal_selesai' => $request->input('TanggalAkhir')
        ]);

        $pelatihan = Pelatihans::create([
            'nama' => $request->input('Nama'),
            'lokasi' => $request->input('Lokasi'),
            'kuota_instruktur' => $request->input('KuotaInstruktur'),
            'kuota' => $request->input('Kuota'),
            'prl' => $request->input('PRL'),
            'id_range_tanggal' => $range_tanggal->id
        ]);

        return redirect()->route('pelatihan')->with('success', 'Pelatihan berhasil ditambahkan');
    }

    // public function storeBidPelatihan(Request $request){
    //     $instrukturId = $request->user()->id;
    //     $pelatihanId = $request->input('pelatihan_id');
    //     $remainingQuota = $request->attributes->get('remainingQuota');

    //     $storeKeTablePelatihanInstruktur = DB::table('pelatihan_instruktur')->insert([
    //         'id_pelatihan' => $pelatihanId,
    //         'id_instruktur' => $instrukturId,
    //         'tanggal_bid' => now(),
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     return redirect(route('cariPelatihan.view'))->with('success', 'Pendaftaran pelatihan berhasil');
    // }

    public function storeBidPelatihan(Request $request, $id)
    {
        $user = Auth::user();
        $pelatihan = Pelatihans::with('relasiDenganRangeTanggal')->findOrFail($id);
    
        // Ambil bulan dan tahun pelatihan
        $bulanPelatihan = Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->month;
        $tahunPelatihan = Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->year;
    
        // Hitung total bid instruktur untuk bulan dan tahun yang sama
        $totalBid = pelatihanInstruktur::where('id_instruktur', $user->id)
            ->whereYear('tanggal_bid', $tahunPelatihan)
            ->whereMonth('tanggal_bid', $bulanPelatihan)
            ->count();
    
        $kuotaPerBulan = 3;
        $sisaKuotaBid = $kuotaPerBulan - $totalBid;
    
        // Validasi role
        if ($user->role != 'instruktur') {
            return redirect(route('cariPelatihan.view'))->with('error', 'Aksi Dilarang');
        }
    
        // Validasi sisa kuota
        if ($sisaKuotaBid <= 0) {
            return redirect(route('cariPelatihan.view'))->with('error', 'Kuota bulanan Anda sudah habis.');
        }
    
        // Validasi kuota instruktur pelatihan
        if ($pelatihan->kuota_instruktur <= 0) {
            return redirect(route('cariPelatihan.view'))->with('error', 'Kuota instruktur pelatihan ini sudah habis.');
        }
    
        // Simpan bid
        DB::table('pelatihan_instruktur')->insert([
            'id_pelatihan' => $pelatihan->id,
            'id_instruktur' => $user->id,
            'tanggal_bid' => now(),
        ]);
    
        // Kurangi kuota instruktur pelatihan
        $pelatihan->decrement('kuota_instruktur');
    
        return redirect(route('cariPelatihan.view'))->with('success', 'Pendaftaran pelatihan berhasil.');
    }

    // Fungsi untuk menghasilkan warna acak
    private function generateRandomColor()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    // Fungsi untuk menentukan warna teks kontras
    private function getContrastColor($hex)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Menggunakan rumus luminansi untuk menentukan kontras
        $contrast = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($contrast > 127) ? '#000000' : '#FFFFFF'; // Hitam jika terang, putih jika gelap
    }


    public function calendarInstruktur()
    {
        $userId = Auth::id(); // ID instruktur yang login
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Ambil pelatihan yang terkait dengan instruktur yang login
        $pelatihanQuery = Pelatihans::whereHas('relasiDenganInstruktur', function ($query) use ($userId) {
            $query->where('id_instruktur', $userId);
        })
            ->with(['relasiDenganInstruktur.user', 'relasiDenganRangeTanggal']);

        // Debug: Output query result to check if pelatihans are retrieved correctly
        // dd($pelatihanQuery->get());

        $events = $pelatihanQuery->get()->map(function ($pelatihan) {

            $start = $pelatihan->relasiDenganRangeTanggal->tanggal_mulai;
            $end = $pelatihan->relasiDenganRangeTanggal->tanggal_selesai;
            $end = date('Y-m-d', strtotime($end . ' +1 day'));

            $instrukturs = $pelatihan->relasiDenganInstruktur->map(function ($pelatihanInstruktur) {
                return $pelatihanInstruktur->user ? $pelatihanInstruktur->user->name : 'Unknown';
            })->toArray();

            // Generate warna acak
            $backgroundColor = $this->generateRandomColor();
            $textColor = $this->getContrastColor($backgroundColor);

            return [
                'title' => $pelatihan->nama,
                'start' => $start,
                'end' => $end,
                'instrukturs' => $instrukturs,
                'backgroundColor' => $backgroundColor,
                'borderColor' => $backgroundColor, // Jika ingin border juga memiliki warna yang sama
                'color' => $textColor, // Warna teks yang kontras
            ];
        });

        return response()->json($events);
    }
}
