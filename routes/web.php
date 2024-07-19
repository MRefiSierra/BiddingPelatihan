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
Route::get('/', [Controller::class, 'login'])->name('signin.view')->middleware('guest');
Route::post('/login', [Controller::class, 'loginStore'])->name('signin.store');

Route::get('/logout', [Controller::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard')->middleware('auth');



