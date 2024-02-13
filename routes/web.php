<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\depanController;
use App\Http\Controllers\skillController;
use App\Http\Controllers\halamanController;
use App\Http\Controllers\profilecontroller;
use App\Http\Controllers\educationController;
use App\Http\Controllers\experienceController;
use App\Http\Controllers\pengaturanHalamanController;

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


Route::get('/', [depanController::class, "index"]);

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
});

Route::prefix('dashboard')->group(
    function () {
        Route::get('/', [halamanController::class, 'index']);
        Route::resource('halaman', halamanController::class);
        Route::resource('experience', experienceController::class);
        Route::resource('education', educationController::class);
        Route::get('skill', [skillController::class, "index"])->name('skill.index');
        Route::post('skill', [skillController::class, "update"])->name('skill.update');
        Route::get('profile', [profileController::class, "index"])->name('profile.index');
        Route::post('profile', [profileController::class, "update"])->name('profile.update');
        Route::get('pengaturanhalaman', [pengaturanHalamanController::class, "index"])->name('pengaturanhalaman.index');
        Route::post('pengaturanhalaman', [pengaturanHalamanController::class, "update"])->name('pengaturanhalaman.update');
    }
);
