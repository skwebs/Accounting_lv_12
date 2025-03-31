<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;

Route::get('/posts/trashed', [PostController::class, 'trashed']);
Route::get('/posts/search', [PostController::class, 'search']);
Route::match(['put', 'patch'], '/posts/{id}/restore', [PostController::class, 'restore']);
Route::match(['put', 'patch'], '/posts/restore-all', [PostController::class, 'restoreAll']);
Route::delete('/posts/{id}/delete-forever', [PostController::class, 'forceDelete']);
Route::delete('/posts/delete-all-trashed-forever', [PostController::class, 'forceDeleteAllTrashed']);
Route::apiResource('posts', PostController::class);
