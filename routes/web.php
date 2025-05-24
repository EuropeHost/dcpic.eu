<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LegalController;

Route::post('/locale', function (Request $request) {
    session(['locale' => $request->locale]);
    return back();
})->name('set-locale');

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/auth/redirect', [AuthController::class, 'redirectToDiscord'])->name('login');
Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('login.view');
Route::get('/auth/callback', [AuthController::class, 'handleDiscordCallback']);

Route::middleware('auth')->group(function () {
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
	
    Route::get('/my-images', [ImageController::class, 'myImages'])->name('images.my');
    Route::post('/images', [ImageController::class, 'store'])->name('images.store');
    Route::delete('/images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');
});

Route::get('/recent-uploads', [ImageController::class, 'recentUploads'])->name('images.recent');
Route::get('/images/{image}', [ImageController::class, 'show'])->name('images.show');

Route::get('/legal/{section}', [LegalController::class, 'show'])->name('legal.show');
