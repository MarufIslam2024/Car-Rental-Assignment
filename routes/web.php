<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Frontend\CarController as FrontendCarController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\RentalController as FrontendRentalController;
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

Auth::routes();

Route::prefix('admin')->middleware('role:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.home');
    Route::resource('cars', CarController::class);
    Route::resource('customers', AdminCustomerController::class);
    Route::resource('rentals', RentalController::class);
});

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/cars', [FrontendCarController::class, 'index'])->name('customer.cars.index');
Route::get('/cars-view/{cars}', [FrontendCarController::class, 'CarsView'])->name('cars.view');
Route::get('/pages', [PageController::class, 'Pages'])->name('customer.pages');

Route::prefix('customer')->middleware('role:customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
    Route::post('/rentcar', [FrontendRentalController::class, 'rentcar'])->name('rentcar');
    Route::post('/cancelRent/{rent}', [FrontendRentalController::class, 'cancelRent'])->name('cancelRent');
});