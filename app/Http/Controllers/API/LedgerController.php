<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LedgerController extends Controller
{

    public function index()
    {
        return response()->json(Ledger::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'related_person' => 'required|string',
            'loan_type' => 'required|in:borrowed,lent',
            'total_amount' => 'required|numeric|min:0.01',
        ]);

        $ledger = Ledger::create([
            'user_id' => Auth::id(),
            'related_person' => $request->related_person,
            'loan_type' => $request->loan_type,
            'total_amount' => $request->total_amount,
            'paid_amount' => 0,
            'remaining_amount' => $request->total_amount,
            'status' => 'pending'
        ]);

        return response()->json($ledger, 201);
    }

    public function update(Request $request, $id)
    {
        $ledger = Ledger::where('user_id', Auth::id())->findOrFail($id);

        if ($request->has('paid_amount')) {
            $ledger->increment('paid_amount', $request->paid_amount);
            $ledger->decrement('remaining_amount', $request->paid_amount);
            if ($ledger->remaining_amount <= 0) {
                $ledger->update(['status' => 'completed']);
            }
        }

        return response()->json($ledger);
    }

    public function destroy($id)
    {
        $ledger = Ledger::where('user_id', Auth::id())->findOrFail($id);
        $ledger->delete();
        return response()->json(['message' => 'Ledger entry deleted']);
    }
}
