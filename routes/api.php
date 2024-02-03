<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\RentController;
use Illuminate\Support\Facades\Route;

Route::put('/cars/edit/{id}', [CarController::class, 'update']);
Route::get('/cars/details/{id}', [CarController::class, 'show']);
Route::post('/cars/add', [CarController::class, 'store']);
Route::delete('/cars/remove/{id}', [CarController::class, 'destroy']);
Route::apiResource('/cars', CarController::class);

Route::put('/users/edit/{id}', [UserController::class, 'update']);
Route::get('/users/details/{id}', [UserController::class, 'show']);
Route::post('/users/add', [UserController::class, 'store']);
Route::delete('/users/remove/{id}', [UserController::class, 'destroy']);
Route::apiResource('/users', UserController::class);

Route::get('/rents/user/{id}', [RentController::class, 'index']);
Route::post('/rents/new', [RentController::class, 'store']);
Route::post('/rents/return', [RentController::class, 'returnCar']);

// Route::apiResource('/supports', SupportController::class)->middleware('auth');
