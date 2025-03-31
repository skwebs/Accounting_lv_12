<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AccountController;

Route::middleware('auth:sanctum')->group(function () {
  // Account Management
  Route::get('/accounts', [AccountController::class, 'index']);
  Route::post('/accounts', [AccountController::class, 'store']);
  Route::get('/accounts/{id}', [AccountController::class, 'show']);
  Route::put('/accounts/{id}', [AccountController::class, 'update']);
  Route::delete('/accounts/{id}', [AccountController::class, 'destroy']);
});
