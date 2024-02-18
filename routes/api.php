<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
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

use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;

Route::post('/oauth/token', [AccessTokenController::class, 'issueToken']);
Route::post('/oauth/authorize', [AuthorizationController::class, 'authorize']);
Route::delete('/oauth/token', [AccessTokenController::class, 'revokeToken']);
Route::get('/oauth/tokens', [AccessTokenController::class, 'forUser']);

Route::middleware(['throttle:20,1' , 'cors'])->group(function () {

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);

    Route::post('users', [UserController::class, 'store']);
    Route::middleware('auth:api')->group(function () {
        Route::get('info', [AuthController::class, 'info']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('users/{user}', [UserController::class, 'update']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);
    });
});
