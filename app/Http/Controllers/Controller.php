<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\pelatihanInstruktur;
use App\Models\Pelatihans;
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
        // $user = Auth::user();

        // // Ubah bulan dan tahun untuk pengujian
        // $bulanIni = Carbon::now()->month; // Bulan Agustus
        // $tahunIni = Carbon::now()->year;

        // Log::info('Bulan Sekarang: ' . $bulanIni);
        // Log::info('Tahun Sekarang: ' . $tahunIni);

        // // Periksa apakah ada bid untuk bulan saat ini
        // $totalBid = pelatihanInstruktur::where('id_instruktur', $user->id)
        //     ->whereYear('tanggal_bid', $tahunIni)
        //     ->whereMonth('tanggal_bid', $bulanIni)
        //     ->count();

        // Log::info('Total Bid Bulan Ini: ' . $totalBid);

        // // Tetapkan kuota per bulan menjadi 3
        // $kuotaPerBulan = 3;

        // // Jika tidak ada bid untuk bulan saat ini, tetapkan sisa kuota menjadi 3
        // // Jika ada, hitung sisa kuota
        // if ($totalBid == 0) {
        //     $sisaKuotaBid = $kuotaPerBulan;
        // } else {
        //     $sisaKuotaBid = $kuotaPerBulan - $totalBid;
        // }

        // Log::info('Sisa Kuota: ' . $sisaKuotaBid);

        // // Dapatkan total jumlah bid
        // $allBid = pelatihanInstruktur::withTrashed()->where('id_instruktur', $user->id)->count();

        // // Dapatkan total jumlah pelatihan hanya untuk bulan saat ini
        // $allPelatihan = pelatihanInstruktur::where('id_instruktur', $user->id)
        //     ->whereYear('tanggal_bid', $tahunIni)
        //     ->whereMonth('tanggal_bid', $bulanIni)
        //     ->count();

        // Log::info('Total Pelatihan Bulan Ini: ' . $allPelatihan);

        // return view('index', [
        //     'sisaKuotaBid' => $sisaKuotaBid,
        //     'allBid' => $allBid,
        //     'allPelatihan' => $allPelatihan
        // ]);

        $user = Auth::user();
        $tahunIni = Carbon::now()->year;
        $kuotaPerBulan = 3;

        // Array untuk menyimpan sisa kuota per bulan
        $sisaKuotaBidPerBulan = [];

        // Loop untuk 6 bulan ke depan
        for ($i = 0; $i < 6; $i++) {
            $bulan = Carbon::now()->addMonths($i)->month;
            $tahun = Carbon::now()->addMonths($i)->year;
            $sisaKuotaBidPerBulan[$bulan] = $this->hitungSisaKuota($user->id, $bulan, $tahun, $kuotaPerBulan);
        }

        // Log untuk debugging
        foreach ($sisaKuotaBidPerBulan as $bulan => $sisaKuota) {
            Log::info('Sisa Kuota Bulan ' . $bulan . ': ' . $sisaKuota);
        }

        $allBid = pelatihanInstruktur::withTrashed()->where('id_instruktur', $user->id)->count();

        $pelatihans = Pelatihans::whereHas('relasiDenganInstruktur', function ($query) use ($user) {
            $query->where('id_instruktur', $user->id);
        })
            ->with(['relasiDenganRangeTanggal', 'relasiDenganInstruktur.user'])
            ->take(3)
            ->get();

        $allPelatihan = pelatihanInstruktur::where('id_instruktur', $user->id)
            ->whereYear('tanggal_bid', $tahunIni)
            ->count();

        return view('index', [
            'sisaKuotaBidPerBulan' => $sisaKuotaBidPerBulan,
            'allBid' => $allBid,
            'allPelatihan' => $allPelatihan
        ], compact('pelatihans'));
    }

    public function pelatihanAktif()
    {
        $user = Auth::user();
        $pelatihans = Pelatihans::whereHas('relasiDenganInstruktur', function ($query) use ($user) {
            $query->where('id_instruktur', $user->id);
        })
            ->with(['relasiDenganRangeTanggal', 'relasiDenganInstruktur.user'])
            ->get();

        return view('pelatihan-aktif', compact('pelatihans'));
    }
    private function hitungSisaKuota($instrukturId, $bulan, $tahun, $kuotaPerBulan)
    {
        $totalBid = pelatihanInstruktur::where('id_instruktur', $instrukturId)
            ->whereYear('tanggal_bid', $tahun)
            ->whereMonth('tanggal_bid', $bulan)
            ->count();

        return $kuotaPerBulan - $totalBid;
    }
    // private function hitungSisaKuota($instrukturId, $bulan, $tahun, $kuotaPerBulan)
    // {
    //     $totalBid = pelatihanInstruktur::where('id_instruktur', $instrukturId)
    //         ->whereYear('tanggal_bid', $tahun)
    //         ->whereMonth('tanggal_bid', $bulan)
    //         ->count();

    //     return $kuotaPerBulan - $totalBid;
    // }
}
