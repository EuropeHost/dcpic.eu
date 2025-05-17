<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return 'Welcome to dcpic.eu!';
});

Route::get('/auth/redirect', [AuthController::class, 'redirectToDiscord'])->name('login');
Route::get('/auth/callback', [AuthController::class, 'handleDiscordCallback']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return 'Logged in as ' . auth()->user()->name;
    })->name('dashboard');
});
