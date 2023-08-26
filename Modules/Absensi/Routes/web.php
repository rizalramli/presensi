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

    Route::group(['middleware' => 'admin'], function () {
        Route::resources([
            'daftar-absensi' => AbsensiController::class,
        ]);
    });

    Route::group(['middleware' => 'guru'], function () {
        Route::resources([
            'masuk-absensi' => MasukAbsensiController::class,
            'pulang-absensi' => PulangAbsensiController::class,
            'laporan-absensi' => LaporanAbsensiController::class,
        ]);
    });
});
