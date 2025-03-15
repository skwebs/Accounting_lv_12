<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return $request->input('name');
});


Route::get('/posts/trashed', [PostController::class, 'trashed']);
Route::get('/posts/search', [PostController::class, 'search']);
Route::match(['put', 'patch'], '/posts/{id}/restore', [PostController::class, 'restore']);
Route::match(['put', 'patch'], '/posts/restore-all', [PostController::class, 'restoreAll']);
Route::delete('/posts/{id}/delete-forever', [PostController::class, 'forceDelete']);
Route::delete('/posts/delete-all-trashed-forever', [PostController::class, 'forceDeleteAllTrashed']);
Route::apiResource('posts', PostController::class);


Route::get('/users/trashed', [UserController::class, 'trashed']);
Route::get('/users/search', [UserController::class, 'search']);
Route::match(['put', 'patch'], '/users/{id}/restore', [UserController::class, 'restore']);
Route::match(['put', 'patch'], '/users/restore-all', [UserController::class, 'restoreAll']);
Route::delete('/users/{id}/delete-forever', [UserController::class, 'forceDelete']);
Route::delete('/users/delete-all-trashed-forever', [UserController::class, 'forceDeleteAllTrashed']);
Route::apiResource('users', UserController::class);
