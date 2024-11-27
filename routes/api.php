<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\CourseController;

//public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//auth routes
Route::middleware('auth:api')->group(function(){

    Route::apiResource('students', StudentController::class);
    Route::apiResource('languages', LanguageController::class);
    Route::apiResource('levels', LevelController::class);
    Route::apiResource('courses', CourseController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});

