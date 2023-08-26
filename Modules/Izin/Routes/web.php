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

use Modules\Izin\Http\Controllers\JenisIzinController;
use Modules\Izin\Http\Controllers\IzinController;
use Modules\Izin\Http\Controllers\PengajuanIzinController;
use Modules\Izin\Http\Controllers\PersetujuanIzinController;

Route::prefix('izin')->name('izin.')->group(function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::resources([
            'daftar-izin' => IzinController::class,
            'jenis-izin' => JenisIzinController::class,
        ]);
    });

    Route::group(['middleware' => ['kepala_sekolah', 'guru']], function () {
        Route::resources([
            'pengajuan-izin' => PengajuanIzinController::class,
        ]);
    });

    Route::group(['middleware' => 'kepala_sekolah'], function () {
        Route::resources([
            'persetujuan-izin' => PersetujuanIzinController::class,
        ]);
    });
});
