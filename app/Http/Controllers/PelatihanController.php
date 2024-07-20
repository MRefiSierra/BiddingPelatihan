<?php

namespace App\Http\Controllers;

use App\Models\Pelatihans;
use App\Models\RangeTanggal;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function create(){
        return view('admin.input-pelatihan');
    }

    public function store(Request $request){
        $request->validate([
            'Nama' => 'required|string|max:255',
            'Lokasi' => 'required|string|max:255',
            'KuotaInstruktur' => 'required|integer',
            'Kuota' => 'required|integer',
            'TanggalMulai' => 'required|date',
            'TanggalAkhir' => 'required|date|after_or_equal:TanggalMulai',
        ]);

    
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

        return redirect('/dashboard-admin')->with('success', 'Pelatihan berhasil ditambahkan!');

    }
}
