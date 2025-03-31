<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return response()->json(Account::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bank,credit_card,cash',
            'balance' => 'numeric|min:0',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $account = Account::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        return response()->json($account, 201);
    }

    public function show($id)
    {
        $account = Account::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($account);
    }

    public function update(Request $request, $id)
    {
        $account = Account::where('user_id', Auth::id())->findOrFail($id);
        $account->update($request->all());
        return response()->json($account);
    }

    public function destroy($id)
    {
        $account = Account::where('user_id', Auth::id())->findOrFail($id);
        $account->delete();
        return response()->json(['message' => 'Account deleted']);
    }
}
