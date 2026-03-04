<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Payment;
use App\Services\BalanceService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'amount'     => 'required|numeric|min:0.01',
        ]);

        Payment::create([
            'colocation_id' => $colocation->id,
            'from_user_id'  => auth()->id(),
            'to_user_id'    => $request->to_user_id,
            'amount'        => $request->amount,
        ]);

        return back()->with('success', 'Payment recorded.');
    }
}