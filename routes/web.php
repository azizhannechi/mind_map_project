<?php

use App\Http\Controllers\ObjectifController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CalendarController;


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
    return view('welcome');
});
Route::get('/map', function () {
    return view('map');
});
Route::get('/acceuil', function () {
    return view('acceuil');
});
Route::get('/nouveauObjectif', function () {
    return view('nouveauObjectif');
});
Route::get('/objectif', function () {
    return view('objectif');
});
Route::get('/calendrier', [CalendarController::class, 'index'])->name('calendrier.index');
Route::post('/calendrier', [CalendarController::class, 'store'])->name('calendrier.store');


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');

Route::get('/map', [ObjectifController::class, 'index'])->name('objectifs.index');
Route::post('/objectifs', [ObjectifController::class, 'store'])->name('objectifs.store');
Route::resource('objectif', ObjectifController::class);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
