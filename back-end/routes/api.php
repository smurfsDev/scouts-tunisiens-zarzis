<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\test;
use App\Http\Controllers\TroupeController;
use App\Http\Controllers\Auth\VerificationController;
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::post('/sign-out', [AuthenticationController::class, 'logout']);
    Route::get('/test', [test::class, 'test']);

    Route::apiResource('leaders',LeaderController::class);

    Route::group(['prefix' => '/leaders'], function () {
        Route::put('/{id}/accept', [LeaderController::class, 'accept']);
        Route::put('/{id}/reject', [LeaderController::class, 'reject']);
    });
    Route::group(['prefix' => '/members'], function () {
        Route::put('/{id}/accept', [MembersController::class, 'accept']);
        Route::put('/{id}/reject', [MembersController::class, 'reject']);
    });
    Route::apiResource('members',MembersController::class);
});

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::get('/unique/{id}', [AuthenticationController::class, 'unique']);

Route::group(['prefix' => '/roles'], function () {
    Route::get('/', [RoleController::class, 'index']);
});

Route::group(['prefix' => '/troupes'], function () {
    Route::get('/', [TroupeController::class, 'index']);
});

Route::get('email/verify/{id}', [VerificationController::class,'verify'])->name('verification.verify'); // Make sure to keep this as your route name
Route::get('email/resend/{email}', [VerificationController::class,'resend'])->name('verification.resend');
