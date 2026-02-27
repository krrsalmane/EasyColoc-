<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Services\BalanceService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Colocation $colocation)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $month    = request('month');
        $expenses = $colocation->expenses()->with(['user', 'category']);

        if ($month) {
            $expenses->whereMonth('date', date('m', strtotime($month)))
                     ->whereYear('date', date('Y', strtotime($month)));
        }

        $expenses = $expenses->latest('date')->get();
        $data     = (new BalanceService)->calculate($colocation);

        return view('expenses.index', compact('colocation', 'expenses', 'data'));
    }

    public function create(Colocation $colocation)
    {
        $categories = $colocation->categories;
        $members    = $colocation->members()->wherePivotNull('left_at')->get();
        return view('expenses.create', compact('colocation', 'categories', 'members'));
    }

    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'user_id'     => 'required|exists:users,id',
        ]);

        Expense::create([
            'colocation_id' => $colocation->id,
            'user_id'       => $request->user_id,
            'category_id'   => $request->category_id,
            'title'         => $request->title,
            'amount'        => $request->amount,
            'date'          => $request->date,
        ]);

        return redirect()->route('expenses.index', $colocation)->with('success', 'Expense added.');
    }

    public function destroy(Colocation $colocation, Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Expense deleted.');
    }
}