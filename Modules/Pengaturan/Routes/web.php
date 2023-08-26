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

use Modules\Pengaturan\Http\Controllers\DaftarUserController;
use Modules\Pengaturan\Http\Controllers\JamKerjaController;
use Modules\Pengaturan\Http\Controllers\InstansiController;
use Modules\Pengaturan\Http\Controllers\LokasiController;
use Modules\Pengaturan\Http\Controllers\HariLiburController;

Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::resources([
            'daftar-user' => DaftarUserController::class,
            'hari-libur' => HariLiburController::class,
            'instansi' => InstansiController::class,
            'lokasi' => LokasiController::class,
            'jam-kerja' => JamKerjaController::class,
        ]);
    });

    Route::group(['middleware' => 'guru'], function () {
        Route::resources([
            'ubah-password' => UbahPasswordController::class,
        ]);
    });
});
