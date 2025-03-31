<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;




// login
Route::post('/login', function (Request $request) {
  $validated = $request->validate([
    'email' => 'required|email|exists:users',
    'password' => 'required',
  ]);

  $user = User::where('email', $request->email)->first();

  if (! $user || ! Hash::check($request->password, $user->password)) {
    throw ValidationException::withMessages([
      'email' => ['The provided credentials are incorrect.'],
    ]);
  }
  // create a new token
  $token = $user->createToken($validated['email'])->plainTextToken;
  // return success message
  return response()->json(['user' => $user, 'token' => $token, 'message' => 'User logged in successfully.'], 200);
});

// register
Route::post('/register', function (Request $request) {
  $validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:6',
  ]);
  $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
  ]);
  $token = $user->createToken($validated['email'])->plainTextToken;
  // return success message
  return response()->json(['user' => $user, 'token' => $token, 'message' => 'User created successfully.'], 201);
});


// protected routes
Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', function (Request $request) {

    /*
    // Revoke all tokens...
$user->tokens()->delete();

// Revoke the token that was used to authenticate the current request...
$request->user()->currentAccessToken()->delete();

// Revoke a specific token...
$user->tokens()->where('id', $tokenId)->delete();

    */
    $request->user()->currentAccessToken()->delete();
    // Auth::user()->currentAccessToken()->delete();
    return response()->json(['message' => 'User logged out successfully.'], 200);
  });
});
