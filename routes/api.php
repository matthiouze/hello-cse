<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;

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

Route::post('login', [LoginController::class, 'login']);
Route::get('profiles', [ProfileController::class, 'index']);

Route::middleware(['auth:sanctum', 'user_id_admin'])
    ->group(function () {
        Route::post('profiles', [ProfileController::class, 'store']);
        Route::put('profiles/{profile}', [ProfileController::class, 'update']);
        Route::delete('profiles/{profile}', [ProfileController::class, 'delete']);

        Route::post('profiles/{profile}/comments', [CommentController::class, 'store']);
    });
