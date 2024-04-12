<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;

// User registration route
Route::post('/register', [RegisterController::class, 'register']);

// Other API routes can be defined here
