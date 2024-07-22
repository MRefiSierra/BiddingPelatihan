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

        $bulanPelatihan = Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->month;
        $tahunPelatihan = Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->year;

        // Hitung jumlah bid yang sudah dilakukan user untuk pelatihan di bulan dan tahun yang sama
        $totalBid = pelatihanInstruktur::where('id_instruktur', $user->id)
            ->whereYear('tanggal_bid', $tahunPelatihan)
            ->whereMonth('tanggal_bid', $bulanPelatihan)
            ->count();

        $kuotaPerBulan = 3;
        $sisaKuotaBid = $kuotaPerBulan - $totalBid;

        if ($user->role != 'instruktur') {
            return redirect(route('cariPelatihan.view'))->with('error', 'Aksi Dilarang');
        };

        if ($sisaKuotaBid == 0) {
            return redirect(route('cariPelatihan.view'))->with('error', 'Bid melebihi batas(3)');
        }

        if ($pelatihan->kuota_instruktur == 0) {
            return redirect(route('cariPelatihan.view'))->with('error', 'Kuota habis');
        }

        DB::table('pelatihan_instruktur')->insert([
            'id_pelatihan' => $pelatihan->id,
            'id_instruktur' => $user->id,
            'tanggal_bid' => now(),
        ]);

        $pelatihan->decrement('kuota_instruktur');

        return redirect(route('cariPelatihan.view'))->with('success', 'Pendaftaran pelatihan berhasil');
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
