<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\pelatihanInstruktur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function login()
    {
        $title = "Login";
        return view('signin', compact('title'));
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function loginStore(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->with('loginError', 'Email atau Password Salah!');
    }

    // protected function redirectRole(){
    //     if(Auth::user()->role == 'admin'){
    //         return redirect('/dashboard-admin');
    //     }else{
    //         return redirect('/dashboard');
    //     }
    // }

    public function dashboard()
    {
        $user = Auth::user();

        // Ubah bulan dan tahun untuk pengujian
        $bulanIni = 8; // Bulan Agustus
        $tahunIni = Carbon::now()->year;

        Log::info('Bulan Sekarang: ' . $bulanIni);
        Log::info('Tahun Sekarang: ' . $tahunIni);

        // Periksa apakah ada bid untuk bulan saat ini
        $totalBid = pelatihanInstruktur::where('id_instruktur', $user->id)
            ->whereYear('tanggal_bid', $tahunIni)
            ->whereMonth('tanggal_bid', $bulanIni)
            ->count();

        Log::info('Total Bid Bulan Ini: ' . $totalBid);

        // Tetapkan kuota per bulan menjadi 3
        $kuotaPerBulan = 3;

        // Jika tidak ada bid untuk bulan saat ini, tetapkan sisa kuota menjadi 3
        // Jika ada, hitung sisa kuota
        if ($totalBid == 0) {
            $sisaKuotaBid = $kuotaPerBulan;
        } else {
            $sisaKuotaBid = $kuotaPerBulan - $totalBid;
        }

        Log::info('Sisa Kuota: ' . $sisaKuotaBid);

        // Dapatkan total jumlah bid
        $allBid = pelatihanInstruktur::where('id_instruktur', $user->id)->count();

        // Dapatkan total jumlah pelatihan hanya untuk bulan saat ini
        $allPelatihan = pelatihanInstruktur::where('id_instruktur', $user->id)
            ->whereYear('tanggal_bid', $tahunIni)
            ->whereMonth('tanggal_bid', $bulanIni)
            ->count();

        Log::info('Total Pelatihan Bulan Ini: ' . $allPelatihan);

        return view('index', [
            'sisaKuotaBid' => $sisaKuotaBid,
            'allBid' => $allBid,
            'allPelatihan' => $allPelatihan
        ]);
    }
}
