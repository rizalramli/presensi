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

use Modules\Laporan\Http\Controllers\LaporanAbsensiController;
use Modules\Laporan\Http\Controllers\LaporanIzinController;
use Modules\Laporan\Http\Controllers\LaporanCutiController;

Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::resources([
        'absensi' => LaporanAbsensiController::class,
        'izin' => LaporanIzinController::class,
        'cuti' => LaporanCutiController::class,
    ]);
});
