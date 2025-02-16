<?php

use App\Http\Controllers\Api\studendController; 
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;



Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/students', [studendController::class, 'index']);
    Route::get('/students/{id}', [studendController::class, 'getstudent']);
    Route::post('/students', [studendController::class, 'createstudent']);
    Route::put('/students/{id}', [studendController::class, 'updatestudent']);
    Route::patch('/students/{id}/', [studendController::class, 'patchStudent']);
    Route::delete('/students/{id}', [studendController::class, 'deletestudent']);
    Route::get('/tokens', [AuthController::class, 'getActiveTokens']);
});