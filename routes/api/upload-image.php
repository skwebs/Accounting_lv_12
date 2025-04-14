<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\API\TransactionController;

// Route::get('/transactions', [TransactionController::class, 'index']);




use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;

Route::post('/upload-image', [ImageUploadController::class, 'upload']);