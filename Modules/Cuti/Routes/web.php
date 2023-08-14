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

Route::prefix('cuti')->name('cuti.')->group(function () {
    Route::resources([
        '/' => CutiController::class,
        'jenis-cuti' => JenisCutiController::class,
    ]);
});
