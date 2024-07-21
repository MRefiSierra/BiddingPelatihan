<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\pelatihanInstruktur;
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
        $user = Auth::user();
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalBid = pelatihanInstruktur::where('id_instruktur', $user->id)
            ->whereYear('tanggal_bid', $tahunIni)
            ->whereMonth('tanggal_bid', $bulanIni)
            ->count();

        $kuotaPerBulan = 3;

        $sisaKuotaBid = $kuotaPerBulan - $totalBid;

        $allBid = pelatihanInstruktur::where('id_instruktur', $user->id)->count();

        $allPelatihan = pelatihanInstruktur::where('id_instruktur', $user->id)->pluck('id_pelatihan')->count();


        return view('index', ['sisaKuotaBid' => $sisaKuotaBid, 'allBid' => $allBid, 'allPelatihan' => $allPelatihan]);
    }
}
