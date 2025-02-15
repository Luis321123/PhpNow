<?php

use App\Http\Controllers\api\studendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/students',[studendController::class,'index']);
Route::get('/students/{id}',[studendController::class,'getstudent']);

Route::post('/students',[studendController::class,'createstudent']);

Route::put('/students/{id}',[studendController::class,'updatestudent']);
Route::patch('/students/{id}/',[studendController::class,'patchStudent']);
Route::delete('/students/{id}',[studendController::class,'deletestudent']);

