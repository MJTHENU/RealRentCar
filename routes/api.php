<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\CarSearchApiController;

// User registration route
Route::post('/register', [RegisterController::class, 'register']);

// User login route
Route::post('login', [LoginController::class, 'login']);

// View User route
Route::apiResource('users', ApiUserController::class);
// Cars API Routes
Route::apiResource('cars', CarController::class);
// Enquiries API Routes
Route::apiResource('enquiries', EnquiryController::class);
// Cars Search API Routes
Route::post('cars/search', [CarSearchApiController::class, 'search']);
