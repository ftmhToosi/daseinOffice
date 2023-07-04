<?php

use App\Http\Controllers\Api\v1\AboutController;
use App\Http\Controllers\Api\v1\ContactController;
use App\Http\Controllers\Api\v1\MediaController;
use App\Http\Controllers\Api\v1\ProjectController;
use App\Http\Controllers\Api\v1\RegisterController;
use App\Http\Controllers\Api\v1\ScaleController;
use App\Http\Controllers\Api\v1\StatusController;
use App\Http\Controllers\Api\v1\TypeController;
use App\Http\Controllers\Api\v1\WeblogController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::/*middleware('auth:api')->*/prefix('v1')->name('Api/v1')->group(function (){
    Route::apiResource('type', TypeController::class);
    Route::apiResource('status', StatusController::class);
    Route::apiResource('scale', ScaleController::class);
    Route::apiResource('project', ProjectController::class)->parameters(['project' => 'slug']);
    Route::apiResource('weblog', WeblogController::class)->parameters(['weblog' => 'slug']);
    Route::apiResource('about', AboutController::class);
    Route::apiResource('media', MediaController::class);
    Route::apiResource('contact', ContactController::class);
    Route::put('edit_social_media', [MediaController::class, 'edit']);

    Route::post('register', [RegisterController::class, 'register']);
    Route::post('logout', [RegisterController::class, 'logout']);
    Route::post('refresh', [RegisterController::class, 'refresh']);
    Route::post('login', [RegisterController::class, 'login']);
});
