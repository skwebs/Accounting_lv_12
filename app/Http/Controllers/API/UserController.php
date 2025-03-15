<?php


namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(['data' => User::all(), 'message' => 'Users retrieved.'], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);
        return response()->json(['data' => $user, 'message' => 'User created.'], 201);
    }

    public function show($id)
    {
        $user = User::find($id);
        return $user ? response()->json(['data' => $user, 'message' => 'User retrieved.'], 200) :
            response()->json(['message' => 'User not found.'], 404);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);
        return response()->json(['data' => $user, 'message' => 'User updated.'], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted.'], 200);
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->get();
        return $users->isEmpty() ? response()->json(['message' => 'No trashed users found.'], 404) :
            response()->json(['data' => $users, 'message' => 'Trashed users retrieved.'], 200);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $user->restore();
        return response()->json(['data' => $user, 'message' => 'User restored.'], 200);
    }

    public function restoreAll()
    {
        User::onlyTrashed()->restore();
        return response()->json(['message' => 'All trashed users restored.'], 200);
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $user->forceDelete();
        return response()->json(['message' => 'User deleted permanently.'], 200);
    }

    public function forceDeleteAllTrashed()
    {
        User::onlyTrashed()->forceDelete();
        return response()->json(['message' => 'All trashed users deleted permanently.'], 200);
    }

    public function search(Request $request)
    {
        $users = User::where('name', 'like', "%{$request->keyword}%")
            ->orWhere('email', 'like', "%{$request->keyword}%")
            ->get();
        return response()->json(['data' => $users, 'message' => 'Search results.'], 200);
    }
}


// namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Http\Request;

// class UserController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         //
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         //
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(User $user)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(User $user)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, User $user)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(User $user)
//     {
//         //
//     }
// }
