<?php

namespace App\Http\Controllers;

use App\Models\pelatihanInstruktur;
use Carbon\Carbon;
use App\Models\Pelatihans;
use App\Models\User;
use App\Models\RangeTanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelatihanController extends Controller
{

    // Instruktur

    // Cari Pelatihan
    public function cariPelatihan()
    {

        $pelatihans = Pelatihans::with('relasiDenganRangeTanggal')->get();
        $user = Auth::user();

        foreach ($pelatihans as $pelatihan) {
            $pelatihan->sudahBid = pelatihanInstruktur::where('id_pelatihan', $pelatihan->id)
                ->where('id_instruktur', $user->id)
                ->exists();
            $pelatihan->KuotaInstruktur = $pelatihan->kuota_instruktur <= 0;
        }

        return view('cari-pelatihan', ['pelatihans' => $pelatihans]);
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
        $pelatihans = Pelatihans::with(['relasiDenganRangeTanggal', 'relasiDenganInstruktur.user'])->get();
        return view('admin.pelatihan', compact('pelatihans'));
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

        return redirect('/dashboard-admin');
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
        $pelatihan = Pelatihans::findOrFail($id);
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalBid = pelatihanInstruktur::where('id_instruktur', $user->id)
            ->whereYear('tanggal_bid', $tahunIni)
            ->whereMonth('tanggal_bid', $bulanIni)
            ->count();

        $kuotaPerBulan = 3;

        $sisaKuotaBid = $kuotaPerBulan - $totalBid;

        if ($user->role != 'instruktur') {
            return response()->json(['message' => 'Unauthorized'], 403);
        };

        if ($sisaKuotaBid == 0) {
            return redirect(route('cariPelatihan.view'))->with('Fail', 'Bid melebihi batas(3)');
        }

        if ($pelatihan->kuota_instruktur == 0) {
            return response()->json(['message' => 'Kuota Abis'], 403);
        }

        DB::table('pelatihan_instruktur')->insert([
            'id_pelatihan' => $pelatihan->id,
            'id_instruktur' => $user->id,
            'tanggal_bid' => now(),
        ]);

        $pelatihan->decrement('kuota_instruktur');

        return redirect(route('cariPelatihan.view'))->with('success', 'Pendaftaran pelatihan berhasil');
    }
}
