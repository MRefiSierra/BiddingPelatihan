<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pelatihans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\pelatihanInstruktur;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
            $key = $bulan . '-' . $tahun; // Membuat key dari bulan dan tahun
            $sisaKuotaBidPerBulan[$key] = $this->hitungSisaKuota($user->id, $bulan, $tahun, $kuotaPerBulan);
        }
    
        // Log untuk debugging
        foreach ($sisaKuotaBidPerBulan as $key => $sisaKuota) {
            Log::info('Sisa Kuota Bulan ' . $key . ': ' . $sisaKuota);
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
            'allPelatihan' => $allPelatihan,
            'pelatihans' => $pelatihans
        ]);
    }
    
    private function hitungSisaKuota($instrukturId, $bulan, $tahun, $kuotaPerBulan)
    {
        // Menghitung total bid berdasarkan tanggal_mulai pelatihan
        $totalBid = DB::table('pelatihan_instruktur')
            ->join('pelatihans', 'pelatihan_instruktur.id_pelatihan', '=', 'pelatihans.id')
            ->join('range_tanggal', 'pelatihans.id_range_tanggal', '=', 'range_tanggal.id')
            ->where('pelatihan_instruktur.id_instruktur', $instrukturId)
            ->whereYear('range_tanggal.tanggal_mulai', $tahun)
            ->whereMonth('range_tanggal.tanggal_mulai', $bulan)
            ->count();
    
        return $kuotaPerBulan - $totalBid;
    }
    public function pelatihanAktif()
{
    $user = Auth::user();
    $pelatihans = Pelatihans::whereHas('relasiDenganInstruktur', function ($query) use ($user) {
        $query->where('id_instruktur', $user->id);
    })
    ->with(['relasiDenganRangeTanggal', 'relasiDenganInstruktur.user'])
    ->get();

    // Mengurutkan pelatihan berdasarkan tanggal mulai
    $pelatihans = $pelatihans->sortBy(function($item) {
        return Carbon::parse($item->relasiDenganRangeTanggal->tanggal_mulai);
    });

    // Pisahkan pelatihan yang sudah lewat
    $hariIni = Carbon::now();
    $pelatihanAkanDatang = $pelatihans->filter(function($item) use ($hariIni) {
        return Carbon::parse($item->relasiDenganRangeTanggal->tanggal_mulai)->isFuture();
    });

    // Kelompokkan pelatihan berdasarkan bulan dan tahun
    $pelatihanPerBulan = $pelatihanAkanDatang->groupBy(function($item) {
        return Carbon::parse($item->relasiDenganRangeTanggal->tanggal_mulai)->format('F Y');
    });

    return view('pelatihan-aktif', [
        'pelatihanPerBulan' => $pelatihanPerBulan,
    ]);
}

public function pelatihanHistory(){
    $user = Auth::user();
    $pelatihans = Pelatihans::whereHas('relasiDenganInstruktur', function ($query) use ($user) {
        $query->where('id_instruktur', $user->id);
    })
    ->with(['relasiDenganRangeTanggal', 'relasiDenganInstruktur.user'])
    ->get();

    // Pisahkan pelatihan yang sudah lewat
    $hariIni = Carbon::now();
    $pelatihanLewat = $pelatihans->filter(function($item) use ($hariIni) {
        return Carbon::parse($item->relasiDenganRangeTanggal->tanggal_mulai)->isPast();
    });

    // Kelompokkan pelatihan yang sudah lewat berdasarkan bulan dan tahun
    $pelatihanPerBulan = $pelatihanLewat->groupBy(function($item) {
        return Carbon::parse($item->relasiDenganRangeTanggal->tanggal_mulai)->format('F Y');
    });

    return view('pelatihan-history', [
        'pelatihanPerBulan' => $pelatihanPerBulan,
    ]);
}


}
