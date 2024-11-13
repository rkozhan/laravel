<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::post('/register', [AuthController::class, 'createUser']);

//Route::get('/events', [EventController::class, 'index']);
