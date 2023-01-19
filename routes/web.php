<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


Route::get('/users/list', [UserController::class, 'index'])->name('users.list')->middleware('auth');

Route::get('/users/show/{user}', [UserController::class, 'show'])->name('users.show')->middleware('auth');

Route::delete('/users/delete/{user}',[UserController::class,'destroy'])->name('user.destroy')->middleware('auth');

Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update')->middleware('auth');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('auth');
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('auth');




Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
