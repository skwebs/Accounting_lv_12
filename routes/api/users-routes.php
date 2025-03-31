<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::get('/users/trashed', [UserController::class, 'trashed']);
Route::get('/users/search', [UserController::class, 'search']);
Route::match(['put', 'patch'], '/users/{id}/restore', [UserController::class, 'restore']);
Route::match(['put', 'patch'], '/users/restore-all', [UserController::class, 'restoreAll']);
Route::delete('/users/{id}/delete-forever', [UserController::class, 'forceDelete']);
Route::delete('/users/delete-all-trashed-forever', [UserController::class, 'forceDeleteAllTrashed']);
Route::apiResource('users', UserController::class);
