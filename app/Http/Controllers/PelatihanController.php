<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pelatihans;
use App\Models\RangeTanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelatihanController extends Controller
{

    // Instruktur

    // Cari Pelatihan
    public function cariPelatihan(){

        $pelatihans = Pelatihans::with('relasiDenganRangeTanggal')->get();

        return view('cari-pelatihan',['pelatihans' => $pelatihans]);
    }

    public function create(){
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

        $akhirnya = Pelatihans::create([
            'nama' => $request->input('Nama'),
            'lokasi' => $request->input('Lokasi'),
            'kuota_instruktur' => $request->input('KuotaInstruktur'),
            'kuota' => $request->input('Kuota'),
            'id_range_tanggal' => $range_tanggal->id
        ]);

        return redirect('/dashboard-admin');
    }

    public function storeBidPelatihan(Request $request){
        $instrukturId = $request->user()->id;
        $pelatihanId = $request->input('pelatihan_id');
        $remainingQuota = $request->attributes->get('remainingQuota');

        $storeKeTablePelatihanInstruktur = DB::table('pelatihan_instruktur')->insert([
            'id_pelatihan' => $pelatihanId,
            'id_instruktur' => $instrukturId,
            'tanggal_bid' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect(route('cariPelatihan.view'))->with('success', 'Pendaftaran pelatihan berhasil');
    }



    
    
}
