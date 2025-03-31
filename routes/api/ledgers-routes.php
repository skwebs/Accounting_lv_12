<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LedgerController;

Route::middleware('auth:sanctum')->group(function () {

  // Ledger (Debtors & Creditors)
  Route::get('/ledgers', [LedgerController::class, 'index']);
  Route::post('/ledgers', [LedgerController::class, 'store']);
  Route::put('/ledgers/{id}', [LedgerController::class, 'update']);
  Route::delete('/ledgers/{id}', [LedgerController::class, 'destroy']);
});
