<?php

use App\Http\Controllers\Front\PositionsController;
use App\Http\Controllers\Front\UsersController;
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

Route::get('/',     function(){ return redirect( route('users') ); })->name('root');

Route::get('/users/{id?}',  [UsersController::class, 'index'])->name('users');
Route::get('/position',     [PositionsController::class, 'index'])->name('positions');
