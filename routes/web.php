<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\RoomController;

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

// Authentication Routes
Route::get('/', [AuthController::class, 'index'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Admin Routes
Route::group(['prefix' => 'admin/'], function() {
    Route::resource("admins", AdminController::class);
    Route::resource("landlords", LandlordController::class);
});
// Landlord Routes
Route::group(['prefix' => 'landlord/'], function() {
    Route::resource("apartments", ApartmentController::class);
    Route::resource("{id}/rooms", RoomController::class);
    Route::post("{apartment}/rooms/{room}/upload", 
        [RoomController::class, "userUploadImage"])->name("rooms.upload");
});
// Client Routes
Route::group(['prefix' => 'user/'], function() {
    
});