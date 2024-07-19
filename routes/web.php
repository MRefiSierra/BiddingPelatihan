<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
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
Route::get('/signin', [Controller::class, 'index'])->name('signin');

Route::get('/', function () {
    return view('welcome');
});

route::get('/dashboard-admin', function (){
    return view('admin.dashboard-admin');
});

route::get('/input-pelatihan', function(){
    return view('admin.input-pelatihan');
});

