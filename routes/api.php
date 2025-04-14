<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return $request->input('name');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);
        return ['token' => $token->plainTextToken];
    });
});



require __DIR__ . '/api/auth.php';
require __DIR__ . '/api/posts-routes.php';
require __DIR__ . '/api/accounts-routes.php';
require __DIR__ . '/api/transactions-routes.php';
require __DIR__ . '/api/ledgers-routes.php';
require __DIR__ . '/api/upload-image.php';
