<?php

use Illuminate\Support\Facades\Route;

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
Route::redirect('/', '/en');

Route::group(['prefix' => '{locale}'], function () {
    Route::get('/', [IndexController::class, 'welcome'])->name('welcome');
    Route::get('/login', [IndexController::class, 'viewmasuk'])->name('viewmasuk');
    Route::get('/register', [IndexController::class, 'viewdaftar'])->name('viewdaftar');

    Route::post('/login-post', [UserController::class, 'login'])->name('login');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/register-post', [UserController::class, 'register'])->name('register');
    Route::get('/mulaipetisi', [UserController::class, 'mulaiview'])->name('mulaiview');
    Route::post('/dukungpetisi', [UserController::class, 'dukungpetisi'])->middleware('user')->name('dukungpetisi'); 
});
