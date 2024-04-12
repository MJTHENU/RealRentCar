<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;

// User registration route
Route::post('/register', [RegisterController::class, 'register']);

// User login route
Route::post('login', [LoginController::class, 'login']);

// Other API routes can be defined here
