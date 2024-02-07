<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReservationController;

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
    return redirect('/login');
});

Route::middleware(['guest'])->group(function() {
    /************************ START OF AUTHENTICATION ROUTES ************************/
    /* Login and Logout Routes */

    Route::any('login', [LoginController::class, 'loginform'])->name('users.loginform');
    Route::post('loginuser', [LoginController::class, 'login'])->name('users.login');
    Route::post('register', [LoginController::class, 'register'])->name('users.register');
    /************************ END OF AUTHENTICATION ROUTES ************************/
});

Route::group(['middleware' => 'auth'], function () {

Route::any('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Vehicles
Route::any('vehicles', [VehicleController::class, 'index'])->name('vehicle.index');
Route::get('vehicles/add', [VehicleController::class, 'create'])->name('vehicle.add');
Route::post('vehicles/store/{id}', [VehicleController::class, 'store'])->name('vehicle.store');
Route::get('vehicles/edit/{id}', [VehicleController::class, 'edit'])->name('vehicle.edit');
Route::get('vehicles/delete/{id}', [VehicleController::class, 'destroy'])->name('vehicle.delete');

// Drivers
Route::any('drivers', [DriverController::class, 'index'])->name('driver.index');
Route::get('driver/add', [DriverController::class, 'create'])->name('driver.add');
Route::post('driver/store/{id}', [DriverController::class, 'store'])->name('driver.store');
Route::get('driver/edit/{id}', [DriverController::class, 'edit'])->name('driver.edit');
Route::get('driver/delete/{id}', [DriverController::class, 'destroy'])->name('driver.delete');

// Reservation
Route::any('reservations', [ReservationController::class, 'index'])->name('reservation.index');
Route::get('reservation/add', [ReservationController::class, 'create'])->name('reservation.add');
Route::post('reservation/store/{id}', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('reservation/edit/{id}', [ReservationController::class, 'edit'])->name('reservation.edit');
Route::get('reservation/delete/{id}', [ReservationController::class, 'destroy'])->name('reservation.delete');


});
    
