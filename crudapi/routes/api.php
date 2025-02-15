<?php

use App\Http\Controllers\api\studendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/students',[studendController::class,'index']);
Route::get('/students/{id}',[studendController::class,'get']);

Route::post('/students',[studendController::class,'create']);

Route::put('/students/{id}');
Route::delete('/students/{id}',[studendController::class,'delete']);

