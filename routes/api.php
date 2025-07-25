<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StatsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
|
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public API Routes
Route::get('/stats/global', [StatsController::class, 'globalStats']);

