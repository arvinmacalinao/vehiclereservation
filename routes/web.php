<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\CheckRole;
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

Route::get('user/profile/{id}', [UserController::class, 'profile'])->name('user.profile');
Route::any('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Reservation
Route::any('reservations', [ReservationController::class, 'index'])->name('reservation.index');
Route::get('reservation/add', [ReservationController::class, 'create'])->name('reservation.add');
Route::post('reservation/store/{id}', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('reservation/edit/{id}', [ReservationController::class, 'edit'])->name('reservation.edit');
Route::get('reservation/delete/{id}', [ReservationController::class, 'destroy'])->name('reservation.delete');
Route::get('reservation/view/{id}', [ReservationController::class, 'view'])->name('reservation.view');
Route::get('reservation/{id}/view', [ReservationController::class, 'view2'])->name('reservation.view.view');

/* Notification */
Route::any('notifications', [NotificationController::class, 'index'])->name('notification.list');
Route::any('notifications/unsold', [NotificationController::class, 'unsold'])->name('notification.list.unsold');
Route::any('notifications/sold', [NotificationController::class, 'sold'])->name('notification.list.sold');
Route::get('mark-single-as-read/{notification}', [NotificationController::class, 'markSingleAsRead'])->name('mark-single-as-read');
Route::post('mark-selected-as-read', [NotificationController::class, 'markAsRead'])->name('mark-selected-as-read');

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


});

Route::middleware(['auth', 'checkRole:MANAGER,SUPERADMIN,SUPERVISOR,VICE PRESIDENT'])->group(function () {
    // Routes accessible only to users with the 'admin' role
    // Approval
    Route::any('approvals', [ApprovalController::class, 'index'])->name('approval.index');
    Route::get('approval/add', [ApprovalController::class, 'create'])->name('approval.add');
    Route::post('approval/store/{id}', [ApprovalController::class, 'store'])->name('approval.store');
    Route::get('approval/edit/{id}', [ApprovalController::class, 'edit'])->name('approval.edit');
    Route::get('approval/delete/{id}', [ApprovalController::class, 'destroy'])->name('approval.delete');
    Route::any('approval/{id}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::any('approval/{id}/disapprove', [ApprovalController::class, 'disapprove'])->name('approval.disapprove');

    
});
    
Route::middleware(['auth', 'checkRole:SUPERADMIN'])->group(function () {
    // Routes accessible only to users with the 'admin' role

// users
Route::any('users', [UserController::class, 'index'])->name('user.index');
Route::get('user/add', [UserController::class, 'create'])->name('user.add');
Route::post('user/store/{id}', [UserController::class, 'store'])->name('user.store');
Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::get('user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');

// Roles
Route::any('roles', [RolesController::class, 'index'])->name('role.index');
Route::get('role/add', [RolesController::class, 'create'])->name('role.add');
Route::post('role/store/{id}', [RolesController::class, 'store'])->name('role.store');
Route::get('role/edit/{id}', [RolesController::class, 'edit'])->name('role.edit');
Route::get('role/delete/{id}', [RolesController::class, 'destroy'])->name('role.delete');

// Group
Route::any('groups', [GroupController::class, 'index'])->name('group.index');
Route::get('group/add', [GroupController::class, 'create'])->name('group.add');
Route::post('group/store/{id}', [GroupController::class, 'store'])->name('group.store');
Route::get('group/edit/{id}', [GroupController::class, 'edit'])->name('group.edit');
Route::get('group/delete/{id}', [GroupController::class, 'destroy'])->name('group.delete');

});