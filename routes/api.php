<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\EventController;

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});


//Route::get('events', [EventController::class, 'index']);

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('events', EventController::class);
});

/*
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('events', EventController::class)->except(['index']);
});
*/
