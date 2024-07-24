<?php

use App\Http\Controllers\Controller;
use App\Http\Middleware\khususAdmin;
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

// guest
Route::get('/', [Controller::class, 'login'])->name('signin.view')->middleware('guest');
Route::post('/login', [Controller::class, 'loginStore'])->name('signin.store');
// guest

// auth
Route::group(['midlleware' => ['auth']], function () {
    // auth:user

    Route::get('/logout', [Controller::class, 'logout'])->name('logout')->middleware('auth');
    Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
    Route::get('/pelatihan-aktif', [Controller::class, 'pelatihanAktif'])->name('pelatihan-aktif');
    Route::get('pelatihan-history', [Controller::class, 'pelatihanHistory'])->name('pelatihan-history');
    route::get('/instruktur/calendar', [PelatihanController::class, 'calendarInstruktur'])->name('dashboard.calendar.instruktur.view');
    Route::get('/cari-pelatihan', [PelatihanController::class, 'cariPelatihan'])->name('cariPelatihan.view');
    Route::post('/cari-pelatihan/store/{id}', [PelatihanController::class, 'storeBidPelatihan'])->name('cariPelatihan.store');

        // auth:admin
        Route::group(['middleware' => ['khususAdmin']], function () {
        route::get('/management-user', [AdminController::class, 'managementUser'])->name('managementUser.view');
        Route::get('/management-user/form', [AdminController::class, 'inputUser'])->name('managementUser.view.form');
        Route::post('/management-user/form/store', [AdminController::class, 'storeUser'])->name('managementUser.store');
        Route::get('/management-user/edit/{id}', [AdminController::class, 'editUser'])->name('managementUser.view.form.edit');
        Route::put('/management-user/edit/{id}', [AdminController::class, 'updateUser'])->name('managementUser.update');
        Route::get('/management-user/delete/{id}', [AdminController::class, 'deleteUser'])->name('managementUser.delete');
        Route::get('/admin/calendar', [AdminController::class, 'calendarPelatihan'])->name('dashboard.calendar.view');
        Route::get('/pelatihan', [PelatihanController::class, 'listingPelatihan'])->name('pelatihan');
        Route::get('/input-pelatihan', [PelatihanController::class, 'create'])->name('inputPelatihan');
        Route::post('/input-pelatihan/store', [PelatihanController::class, 'store'])->name('storePelatihan');
        Route::get('/edit-pelatihan/{id}', [PelatihanController::class, 'edit'])->name('editPelatihan');
        Route::put('/edit-pelatihan/{id}', [PelatihanController::class, 'update'])->name('Pelatihan.update.store');
        Route::get('/pelatihan/delete/{id}', [PelatihanController::class, 'deletePelatihan'])->name('pelatihan.delete.store');
        Route::get('/export-excel', [PelatihanController::class, 'exportExcel'])->name('exportExcel.store');

        // Export excel Instruktur
        Route::get('/export-excel/{id}', [PelatihanController::class, 'exportExcelInstruktur'])->name('exportExcelInstruktur.store');

        Route::get('/user-detail/{id}', [AdminController::class, 'userDetail']);
        Route::get('/user-detail/delete/{id}', [AdminController::class, 'deleteInstruktur'])->name('deleteInstrukturPelatihan.store');
        Route::get('/user-detail/{userId}/calendar', [AdminController::class, 'userCalendar']);
    });



    // route::get('/dashboard-admin', function () {
    //     return view('admin.dashboard-admin');
    // });
    // auth:admin


    // Admin (Management User)


    // Admin (Calendar Pelatihan)

    // Admin (Input Pelatihan)
    // route::get('/add-user', function () {
    //     return view('admin.add-user');
    // });

    // Export excel pelatihan



});
