<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('profile', ProfileController::class)->name('profile');
Route::resource('guest', GuestController::class);

Route::put('/guests/{guest}', [GuestController::class, 'update'])->name('guests.update');

