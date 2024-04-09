<?php

use App\Http\Controllers\Back\PositionController;
use App\Http\Controllers\Back\TokenController;
use App\Http\Controllers\Back\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/v1')->group(function () {
    Route::get('/users/{id?}',  [ UsersController::class, 'index'])->name('users.api');
    Route::get('/token',        [ TokenController::class, 'index'])->name('token');
    Route::get('/position',     [ PositionController::class, 'index'])->name('positions.api');

    Route::post('/users',       [ UsersController::class, 'store'])->name('users.store');
});
