<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HpReportController;

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

Route::get('/', function () {
    return view('exe');
});


Route::middleware(['auth', 'verified'])->group(function () {
//Route::resource('')

    /*
     * Raporty HP
     */
    Route::get('/hpreport/index',[HpReportController::class,'index'])->name('hpreport.index');

    Route::get('/hpreport/reports/create',[HpReportController::class,'reportCreate'])->name('hpreport.reports.create');
    Route::post('/hpreport/reports/create',[HpReportController::class,'reportCreate'])->name('hpreport.reports.create');
    Route::post('/hpreport/reports/update',[HpReportController::class,'reportUpdate'])->name('hpreport.reports.update');

    Route::get('/hpreport/reports/list',[HpReportController::class,'reportList'])->name('hpreport.reports.list');
    Route::get('/hpreport/reports/export/{id}',[HpReportController::class,'reportExsport'])->name('hpreport.reports.export');

    Route::get('/hpreport/reports/show/{id}',[HpReportController::class,'reportShow'])->name('hpreport.reports.show');
    Route::get('/hpreport/reports/edit/{id}',[HpReportController::class,'reportEdit'])->name('hpreport.reports.edit');
    Route::delete('/hpreport/reports/destroy/{id}',[HpReportController::class,'reportDestroy'])->name('hpreport.reports.destroy');

    Route::post('/hpreport/reports/getweeks',[HpReportController::class,'getWeeks']);
    Route::post('/hpreport/reports/getreportsno',[HpReportController::class,'getReportsNo']);

    Route::get('/hpreport/articles/list',[HpReportController::class,'articlesList'])->name('hpreport.articles.list');

    Route::get('/hpreport/articles/show/{id}',[HpReportController::class,'articlesShow'])->name('hpreport.articles.show');

    Route::get('/hpreport/articles/purchases/{date?}',[HpReportController::class,'articlesPurchases'])->name('hpreport.articles.purchases');
    Route::get('/hpreport/articles/sale/{date?}',[HpReportController::class,'articlesSale'])->name('hpreport.articles.sale');


    Route::get('/hpreport/customers/list',[HpReportController::class,'customersList'])->name('hpreport.customers.list');
    Route::post('/hpreport/customers/getsfromalt',[HpReportController::class,'getCustomersFromAltum']);
    Route::post('/hpreport/customers/getfromalt',[HpReportController::class,'getCustomerFromAltum']);
    Route::post('/hpreport/customers/add',[HpReportController::class,'addCustomer']);
    Route::delete('/hpreport/customers/delete/{id}',[HpReportController::class,'deleteCustomer'])->name('hpreport.customers.delete');

    Route::middleware(['can:isAdmin'])->group(function () {
        Route::get('/users/list', [UserController::class, 'index'])->name('users.list');
        Route::get('/users/show/{user}', [UserController::class, 'show'])->name('users.show');

        Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

//Route::get('/users/list', [UserController::class, 'index'])->name('users.list')->middleware('auth');
//Route::get('/users/show/{user}', [UserController::class, 'show'])->name('users.show')->middleware('auth');
//Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('auth');
//Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
//Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
//Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('auth');
//Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('auth');


Auth::routes(['verify' => true]);


