<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TransactionController;

Route::middleware('auth:sanctum')->group(function () {

  // Transaction Management
  Route::get('/transactions', [TransactionController::class, 'index']);
  Route::post('/transactions', [TransactionController::class, 'store']);
  Route::get('/transactions/{id}', [TransactionController::class, 'show']);
  Route::put('/transactions/{id}', [TransactionController::class, 'update']);
  Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
});
