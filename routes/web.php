<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\AdminController;

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
	Route::patch('/images/{image}/visibility', [ImageController::class, 'toggleVisibility'])->name('images.toggleVisibility');
	
	Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/', [AdminController::class, 'index'])->name('overview');
		Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    });
});

Route::get('/recent-uploads', [ImageController::class, 'recentUploads'])->name('images.recent');
Route::get('/madia/{image}', [ImageController::class, 'show'])->name('images.show');
Route::get('/images/{image}', [ImageController::class, 'show']);
Route::get('/i/{image}', [ImageController::class, 'show']);
Route::get('/v/{image}', [ImageController::class, 'show']);
Route::get('/img/{image}', [ImageController::class, 'show'])->name('img.show');
Route::get('/vid/{image}', [ImageController::class, 'show'])->name('vid.show');
Route::get('/vdo/{image}', [ImageController::class, 'show']);
Route::get('/image/{image}', [ImageController::class, 'show']);
Route::get('/video/{image}', [ImageController::class, 'show']);
Route::get('/media/{image}', [ImageController::class, 'show']);

Route::get('/legal/{section}', [LegalController::class, 'show'])->name('legal.show');

Route::post('/announcement/dismiss/{id}', function ($id) {
    session()->put("announcement_dismissed_{$id}", true);
    return back();
})->name('announcement.dismiss');
