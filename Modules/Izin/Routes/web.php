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

Route::prefix('izin')->name('izin.')->group(function () {
    Route::resources([
        'jenis-izin' => JenisIzinController::class,
    ]);
});
