<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\CarSearchApiController;
use App\Http\Controllers\Api\ReservationApiController;
use App\Http\Controllers\Api\TariffController;
use App\Http\Controllers\Api\ClientCarController;

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
// Reservations API Routes
// Route::apiResource('/reservations', ReservationApiController::class);
Route::get('/reservations', [ReservationApiController::class, 'index']);
Route::post('/reservations/{car_id}', [ReservationApiController::class, 'store']);
Route::get('/reservations/{id}', [ReservationApiController::class, 'show']);
Route::put('/reservations/{id}', [ReservationApiController::class, 'update']);
Route::delete('/reservations/{id}', [ReservationApiController::class, 'destroy']);

// Tariff API Routes
Route::apiResource('tariffs', TariffController::class);
// Define routes for the ClientCarController
Route::get('/ccars', [ClientCarController::class, 'index']);
Route::get('/ccars/{id}', [ClientCarController::class, 'show']);



