<?php

use App\Modules\Authentication\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes [Authentication]
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login & Logout Routes 
Route::get('/signin',[AuthController::class,'index'])->name('signin')->middleware('guest');
Route::post('/signin',[AuthController::class,'signin'])->middleware('guest');
Route::post('/signout',[AuthController::class,'signout'])->name('signout')->middleware('auth');
