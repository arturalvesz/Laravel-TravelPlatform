<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\ProfileController;

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

Route::get('/', function () {
    return view('home');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware('auth')->group(function (){

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile/{user}', 'show')->name('profile.show');
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::put('/profile/updateProfile', 'updateUser')->name('profile.updateUser');
        Route::post('/profile/storePhoto', 'storePhoto')->name('profile.storePhoto');
        Route::post('/profile/updatePhoto', 'updatePhoto')->name('profile.updatePhoto');
        Route::post('/profile/storeAddress', 'storeAddress')->name('profile.storeAddress');
        Route::post('/profile/updateAddress', 'updateAddress')->name('profile.updateAddress');
    });
});