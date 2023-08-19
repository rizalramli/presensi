<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\Absensi\Http\Controllers\AbsensiController;
use Modules\Absensi\Http\Controllers\LaporanAbsensiController;
use Modules\Absensi\Http\Controllers\MasukAbsensiController;
use Modules\Absensi\Http\Controllers\PulangAbsensiController;

Route::prefix('absensi')->name('absensi.')->group(function () {
    Route::resources([
        'daftar-absensi' => AbsensiController::class,
        'masuk-absensi' => MasukAbsensiController::class,
        'pulang-absensi' => PulangAbsensiController::class,
        'laporan-absensi' => LaporanAbsensiController::class,
    ]);
    Route::get('laporan-absensi2', [LaporanAbsensiController::class, 'index2'])->name('laporan-absensi2');
});
