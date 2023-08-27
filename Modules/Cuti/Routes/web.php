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

use Modules\Cuti\Http\Controllers\CutiController;
use Modules\Cuti\Http\Controllers\JenisCutiController;
use Modules\Cuti\Http\Controllers\PengajuanCutiController;
use Modules\Cuti\Http\Controllers\PersetujuanCutiController;

Route::prefix('cuti')->name('cuti.')->group(function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::resources([
            'daftar-cuti' => CutiController::class,
            'jenis-cuti' => JenisCutiController::class,
        ]);
    });

    Route::group(['middleware' => ['guru']], function () {
        Route::resources([
            'pengajuan-cuti' => PengajuanCutiController::class
        ]);
    });

    Route::group(['middleware' => 'kepala_sekolah'], function () {
        Route::resources([
            'persetujuan-cuti' => PersetujuanCutiController::class
        ]);
    });
});
