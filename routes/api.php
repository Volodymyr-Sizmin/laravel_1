<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users', [UserController::class, 'store']);

Route::post('/login', [UserController::class, 'login']);

Route::post('/reset', [UserController::class, 'resetPassword']);

Route::post('/recovery', [UserController::class, 'recoveryPassword']);

Route::name('auth')->prefix('auth')->middleware('auth:api')->group(function ()
{
    Route::put('/users/{user}',[UserController::class, 'updateUser'])->whereNumber('user');
    Route::get('/users/',[UserController::class, 'index']);
    Route::get('/users/{user}',[UserController::class, 'show'])->whereNumber('user');
});
