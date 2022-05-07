<?php

use App\Modules\Contacts\Http\Controllers\ContactsController;
use App\Modules\Contacts\Http\Controllers\DownloadsController;
use App\Modules\Contacts\Http\Controllers\GroupContactsController;
use App\Modules\Contacts\Http\Controllers\GroupsController;
use App\Modules\Contacts\Http\Controllers\ListsController;
use App\Modules\Contacts\Http\Controllers\PropertiesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes [Contacts]
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Contacts Routes
Route::get('/',[ListsController::class,'index'])->name('lists')->middleware('auth');
Route::get('/list',[ContactsController::class,'index'])->name('list.contacts')->middleware('auth');
Route::get('/list/contacts/trash',[ContactsController::class,'showTrash'])->name('list.contacts.trash')->middleware('auth');
Route::get('/list/contacts/trash/search',[ContactsController::class,'searchTrash'])->name('list.contacts.search-trash')->middleware('auth');
Route::get('/list/contacts/search',[ContactsController::class,'search'])->name('list.contacts.search')->middleware('auth');
Route::post('/list/contacts/trash/retrieve',[ContactsController::class,'retrieve'])->name('list.contacts.retrieve')->middleware('auth');
Route::post('/list/contacts/trash/retrieve-many',[ContactsController::class,'retrieveMany'])->name('list.contacts.retrieve-many')->middleware('auth');
Route::post('/list/contacts/import',[ContactsController::class,'import'])->name('list.contacts.import')->middleware('auth');
Route::post('/list/contacts/import/new-fields',[ContactsController::class,'importPart2'])->name('list.contacts.import.part2')->middleware('auth');
Route::post('/list/contacts/destroy',[ContactsController::class,'destroy'])->name('list.contacts.destroy')->middleware('auth');
Route::post('/list/contacts/destroy-many',[ContactsController::class,'destroyMany'])->name('list.contacts.destroy-many')->middleware('auth');
Route::post('/list/contacts/store',[ContactsController::class,'store'])->name('list.contacts.store')->middleware('auth');
Route::post('/list/contacts/update',[ContactsController::class,'update'])->name('list.contacts.update')->middleware('auth');


// Properties Routes
Route::get('/list/properties',[PropertiesController::class,'index'])->name('list.properties')->middleware('auth');
Route::get('/list/properties/trash',[PropertiesController::class,'showTrash'])->name('list.properties.trash')->middleware('auth');
Route::post('/list/properties/store',[PropertiesController::class,'store'])->name('list.properties.store')->middleware('auth');
Route::post('/list/properties/update',[PropertiesController::class,'update'])->name('list.properties.update')->middleware('auth');
Route::post('/list/properties/destroy',[PropertiesController::class,'destroy'])->name('list.properties.destroy')->middleware('auth');
Route::post('/list/properties/trash/retrieve',[PropertiesController::class,'retrieve'])->name('list.properties.retrieve')->middleware('auth');

// Contact Groups Routes
Route::get('/list/groups',[GroupsController::class,'index'])->name('list.groups')->middleware('auth');
Route::get('/list/groups/trash',[GroupsController::class,'showTrash'])->name('list.groups.trash')->middleware('auth');
Route::post('/list/groups/trash/retrieve',[GroupsController::class,'retrieve'])->name('list.groups.retrieve')->middleware('auth');
Route::post('/list/groups/store',[GroupsController::class,'store'])->name('list.groups.store')->middleware('auth');
Route::post('/list/groups/update',[GroupsController::class,'update'])->name('list.groups.update')->middleware('auth');
Route::post('/list/groups/destroy',[GroupsController::class,'destroy'])->name('list.groups.destroy')->middleware('auth');

// Contacts in Groups Routes
Route::get('/list/group',[GroupContactsController::class,'index'])->name('list.group.contacts')->middleware('auth');
Route::get('/list/group/search',[GroupContactsController::class,'search'])->name('list.group.search')->middleware('auth');
Route::get('/list/group/search-group',[GroupContactsController::class,'searchGroup'])->name('list.group.search-group')->middleware('auth');
Route::post('/list/group/store',[GroupContactsController::class,'store'])->name('list.group.contacts.store')->middleware('auth');
Route::post('/list/group/destroy',[GroupContactsController::class,'destroy'])->name('list.group.contacts.destroy')->middleware('auth');
Route::post('/list/group/destroy-many',[GroupContactsController::class,'destroyMany'])->name('list.group.contacts.destroy-many')->middleware('auth');

Route::get('download/template',[DownloadsController::class,'index'])->name('download.template')->middleware('auth');