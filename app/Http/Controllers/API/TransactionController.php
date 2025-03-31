<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function index()
    {
        return response()->json(Transaction::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:income,expense,transfer,credit_card_payment,loan',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'related_account_id' => 'nullable|exists:accounts,id',
            'transaction_mode' => 'nullable|string',
            'upi_app' => 'nullable|string',
            'transaction_fee' => 'nullable|numeric|min:0',
            'loan_type' => 'nullable|in:borrowed,lent,none',
            'related_person' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction = Transaction::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        // Update account balance
        $account = Account::find($request->account_id);
        if ($request->type === 'income') {
            $account->increment('balance', $request->amount);
        } elseif ($request->type === 'expense' || $request->type === 'credit_card_payment') {
            $account->decrement('balance', $request->amount);
        } elseif ($request->type === 'transfer' && $request->related_account_id) {
            $account->decrement('balance', $request->amount);
            Account::find($request->related_account_id)->increment('balance', $request->amount);
        }

        return response()->json($transaction, 201);
    }

    public function show($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $transaction->update($request->all());
        return response()->json($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted']);
    }
}
