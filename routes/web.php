<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard routes
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    // Profile routes
    Route::controller(ProfileController::class)
        ->prefix('profile')
        ->group(function () {
            Route::get('/', 'edit')->name('profile.edit');
            Route::patch('/', 'update')->name('profile.update');
            Route::delete('/', 'destroy')->name('profile.destroy');
        });

    // Invoice routes
    Route::controller(InvoiceController::class)
        ->prefix('invoices')
        ->group(function () {
            Route::get('/{invoice}/print', 'print')->name('invoices.print');
            Route::get('/export', 'export')->name('invoices.export');
            Route::post('/action', 'action')->name('invoices.action');
        });
    Route::resource('invoices', InvoiceController::class)->except([
        'show'
    ]);
    // Customer routes
    Route::controller(CustomerController::class)
        ->prefix('customers')
        ->group(function () {
            Route::get('/{customer}/archive', 'archive')->name('customers.archive');
            Route::get('/export', 'export')->name('customers.export');
        });
    Route::resource('customers', CustomerController::class);
});

require __DIR__ . '/auth.php';
