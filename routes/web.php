<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelatihanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// auth
Route::get('/', [Controller::class, 'login'])->name('signin.view')->middleware('guest');
Route::post('/login', [Controller::class, 'loginStore'])->name('signin.store');

Route::get('/logout', [Controller::class, 'logout'])->name('logout')->middleware('auth');





Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');

route::get('/dashboard-admin', function (){
    return view('admin.dashboard-admin');
});


route::get('/management-user', [AdminController::class, 'managementUser'])->name('managementUser.view');
Route::get('/management-user/form', [AdminController::class, 'inputUser'])->name('managementUser.view.form');
Route::post('/management-user/form/store', [AdminController::class, 'storeUser'])->name('managementUser.store');


Route::get('/input-pelatihan', [PelatihanController::class, 'create'])->name('inputPelatihan')->middleware(['auth','khususAdmin']);
route::post('/input-pelatihan/store', [PelatihanController::class, 'store'])->name('storePelatihan');

Route::get('/cari-pelatihan', [PelatihanController::class, 'cariPelatihan'])->name('cariPelatihan.view');

