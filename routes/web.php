<?php

use App\Http\Controllers\CustomerController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/Index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Invoice routes
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoices/{invoice}/print', 'print')->name('invoices.print');
        Route::get('/invoices/export', 'export')->name('invoices.export');
    });
    Route::resource('invoices', InvoiceController::class)->except([
        'show'
    ]);
    // Customer routes
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customers/{customer}/archive', 'archive')->name('customers.archive');
        Route::get('/customers/export', 'export')->name('customers.export');
    });
    Route::resource('customers', CustomerController::class);
});

require __DIR__ . '/auth.php';
