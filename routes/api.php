<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ReminderController;

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('events', EventController::class);
});

/*
Route::get('events', [EventController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('events', EventController::class)->except(['index']);
});
*/

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('reminders', ReminderController::class);
});

//Route::get('reminders', [ReminderController::class, 'index']);
