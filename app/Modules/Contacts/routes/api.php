<?php

use App\Modules\Contacts\Http\Controllers\Api\ContactsController;
use App\Modules\Contacts\Http\Controllers\Api\PropertiesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes [Contacts]
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('',[ContactsController::class,'getContacts']);
Route::get('/{id}',[ContactsController::class,'getContactById']);
Route::get('/search/{keywords}',[ContactsController::class,'search']);
Route::post('/search/{userId}',[ContactsController::class,'searchForUser']);
Route::get('/ofuser/{id}',[ContactsController::class,'getContactsOfUser']);
Route::post('/store/{userId}',[ContactsController::class,'store']);
Route::post('/update/{userId}',[ContactsController::class,'update']);
Route::post('/delete/{userId}',[ContactsController::class,'destroy']);
Route::get('/properties/ofuser/{id}',[PropertiesController::class,'getPropsOfUser']);