<?php

use App\Http\Controllers\ProfitController;
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
    Route::middleware(['can:isHPReports'])->group(function () {

        Route::get('/hpreport/index', [HpReportController::class, 'index'])->name('hpreport.index');

        Route::get('/hpreport/reports/create', [HpReportController::class, 'reportCreate'])->name('hpreport.reports.create');
        Route::post('/hpreport/reports/create', [HpReportController::class, 'reportCreate'])->name('hpreport.reports.create');
        Route::post('/hpreport/reports/update', [HpReportController::class, 'reportUpdate'])->name('hpreport.reports.update');

        Route::get('/hpreport/reports/list', [HpReportController::class, 'reportList'])->name('hpreport.reports.list');
        Route::get('/hpreport/reports/export/{id}', [HpReportController::class, 'reportExsport'])->name('hpreport.reports.export');

        Route::get('/hpreport/reports/show/{id}', [HpReportController::class, 'reportShow'])->name('hpreport.reports.show');
        Route::get('/hpreport/reports/edit/{id}', [HpReportController::class, 'reportEdit'])->name('hpreport.reports.edit');
        Route::delete('/hpreport/reports/destroy/{id}', [HpReportController::class, 'reportDestroy'])->name('hpreport.reports.destroy');

        Route::post('/hpreport/reports/getweeks', [HpReportController::class, 'getWeeks']);
        Route::post('/hpreport/reports/getreportsno', [HpReportController::class, 'getReportsNo']);

        Route::get('/hpreport/articles/list', [HpReportController::class, 'articlesList'])->name('hpreport.articles.list');

        Route::get('/hpreport/articles/show/{id}', [HpReportController::class, 'articlesShow'])->name('hpreport.articles.show');

        Route::get('/hpreport/articles/purchases/{date?}', [HpReportController::class, 'articlesPurchases'])->name('hpreport.articles.purchases');
        Route::get('/hpreport/articles/sale/{date?}', [HpReportController::class, 'articlesSale'])->name('hpreport.articles.sale');


        Route::get('/hpreport/customers/list', [HpReportController::class, 'customersList'])->name('hpreport.customers.list');
        Route::post('/hpreport/customers/getsfromalt', [HpReportController::class, 'getCustomersFromAltum']);
        Route::post('/hpreport/customers/getfromalt', [HpReportController::class, 'getCustomerFromAltum']);
        Route::post('/hpreport/customers/add', [HpReportController::class, 'addCustomer']);
        Route::delete('/hpreport/customers/delete/{id}', [HpReportController::class, 'deleteCustomer'])->name('hpreport.customers.delete');
    });
    /*
     * end Raporty HP
     */

    Route::middleware(['can:isProfits'])->group(function () {
        /*
         * profit
        */
        Route::get('/profits/index', [ProfitController::class, 'index'])->name('profits.index');

        Route::get('/profits/devices/list', [ProfitController::class, 'showDevicesList'])->name('profits.devices.list');
        Route::post('/profits/devices/list', [ProfitController::class, 'getDevicesList']);

        Route::get('/profits/devices/profit/{devid}/{agrid}', [ProfitController::class, 'showDeviceProfit'])->name('profits.devices.profit');
        Route::post('/profits/devices/profit', [ProfitController::class, 'getDeviceProfit']);

        Route::post('/profits/doc', [ProfitController::class, 'getDoc']);

        /*
         * end profit
         */
    });


    Route::middleware(['can:isAdmin'])->group(function () {

        /*
         * users
         */
        Route::get('/users/list', [UserController::class, 'index'])->name('users.list');
        Route::get('/users/show/{user}', [UserController::class, 'show'])->name('users.show');
        Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        /*
         * end users
         */

    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});


Auth::routes(['verify' => true]);


