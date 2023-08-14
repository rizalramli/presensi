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

Route::prefix('absensi')->name('absensi.')->group(function () {
    Route::resources([
        '/' => AbsensiController::class,
        'laporan-absensi' => LaporanAbsensiController::class,
    ]);
});
