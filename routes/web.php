<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

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
Auth::routes(['register' => false, 'reset' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(HospitalController::class)->group(function () {
    Route::resource('hospitals', HospitalController::class);
});

Route::controller(PatientController::class)->group(function () {
    Route::resource('patients', PatientController::class);
    Route::get('/table-patient', 'table')->name('patients.table');
});
