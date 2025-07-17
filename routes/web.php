<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LinkController;

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

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
        Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.update_role');
        Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    });

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    //Link Management Routes
    Route::prefix('links')->name('links.')->group(function () {
        Route::get('/my', [LinkController::class, 'myLinks'])->name('my');
        Route::post('/', [LinkController::class, 'store'])->name('store');
        Route::delete('/{link}', [LinkController::class, 'destroy'])->name('destroy');
    });
});

Route::get('/i/{image:slug}', [ImageController::class, 'show'])->name('img.show.slug');
Route::get('/v/{image:slug}', [ImageController::class, 'show'])->name('vid.show.slug');
Route::get('/l/{link:slug}', [LinkController::class, 'show'])->name('links.show');


Route::get('/madia/{image}', [ImageController::class, 'show'])->name('images.show');
Route::get('/images/{image}', [ImageController::class, 'show']);
Route::get('/img/{image}', [ImageController::class, 'show'])->name('img.show');
Route::get('/vid/{image}', [ImageController::class, 'show'])->name('vid.show');
Route::get('/vdo/{image}', [ImageController::class, 'show']);
Route::get('/image/{image}', [ImageController::class, 'show']);
Route::get('/video/{image}', [ImageController::class, 'show']);
Route::get('/media/{image}', [ImageController::class, 'show']);

Route::get('/recent-uploads', [ImageController::class, 'recentUploads'])->name('images.recent');

Route::get('/legal/{section}', [LegalController::class, 'show'])->name('legal.show');

Route::post('/announcement/dismiss/{id}', function ($id) {
    session()->put("announcement_dismissed_{$id}", true);
    return back();
})->name('announcement.dismiss');
