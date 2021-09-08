<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ListingController;

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
Route::group(['prefix'=>'/', 'middleware'=> 'guest'], function(){
    Route::get('/', [AuthController::class, 'index'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
Route::get('/home', function() {
    $user = Auth::user()->userlevel;
    switch($user){
        case 'admin':
            $route = "/admin";
            break;
        case 'landlord':
            $route = "/landlord";
            break;
        default:
            $route = "/user";
    }
    return redirect($route);
})->middleware("auth")->name('home');
Route::group(['middleware' => 'auth'], function(){
    // logout user
    Route::get('/logout', function(){
        Auth::logout();
        return redirect(route('login.show'));
    })->name('logout');
    // Admin Routes
    Route::group(['prefix' => 'admin/'], function() {
        Route::get('', function() {
            return redirect(route('admins.index'));
        });
        Route::resource("admins", AdminController::class);
        Route::resource("landlords", LandlordController::class);
    });
    // Landlord Routes
    Route::group(['prefix' => 'landlord/'], function() {
        Route::get('', function() {
            return redirect(route('apartments.index'));
        });
        Route::resource("apartments", ApartmentController::class);
        Route::resource("{id}/rooms", RoomController::class);
        Route::post("{apartment}/rooms/{room}/upload", 
            [RoomController::class, "userUploadImage"])->name("rooms.upload");
        Route::delete("{room}/{id}/picture/delete", 
            [RoomController::class, "deleteImage"])->name("room.pic.delete");
    });
    // Client Routes
    Route::group(['prefix' => 'user/'], function() {
        Route::get("", [ListingController::class, "index"])->name("list.index");
        Route::get("/room/{room}", [ListingController::class, "show"])->name('list.show');
        Route::post("/room/{room}", [ListingController::class, "book"])->name('appointment.book');
        Route::get("/bookings", [ListingController::class, "bookings"])->name("bookings");
        Route::get("/bookings/{booking}", [ListingController::class, "booking_show"])->name("booking.show");
    });
});
