<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\AuthController;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('books',CourseController::class)->only(['index','show','update'])
->middleware("auth:sanctum");
Route::post("users/{user}/books",[CourseController::class,'store'])
->middleware("auth:sanctum");;
Route::post("login",[AuthController::class,'login']);
Route::post("signup",[AuthController::class,'signup']);