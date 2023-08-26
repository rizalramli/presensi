<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/home2', [App\Http\Controllers\HomeController::class, 'index2'])->name('home2');
    });

    Route::group(['middleware' => 'guru'], function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
});
