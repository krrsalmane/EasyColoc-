<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Mail\InvitationMail;
use App\Services\BalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ColocationController extends Controller
{
    public function index()
    {
        return view('colocations.index');
    }

    public function create()
    {
        return view('colocations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $alreadyMember = $user->colocations()
            ->wherePivotNull('left_at')
            ->where('status', 'active')
            ->exists();

        if ($alreadyMember) {
            return back()->with('error', 'You already have an active colocation.');
        }

        $colocation = Colocation::create([
            'name' => $request->name,
            'status' => 'active',
            'owner_id' => $user->id,
        ]);

        $colocation->members()->attach($user->id, [
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect()->route('colocations.show', $colocation)->with('success', 'Colocation created.');
    }

    public function show(Colocation $colocation)
    {
        $expenses = $colocation->expenses()
            ->with(['user', 'category'])
            ->latest('date')
            ->take(5)
            ->get();

        $categories = $colocation->categories;

        return view('colocations.show', compact('colocation', 'expenses', 'categories'));
    }

    public function storeCategory(\Illuminate\Http\Request $request, Colocation $colocation)
    {
        $request->validate(['name' => 'required|string|max:100']);
        \App\Models\Category::create([
            'colocation_id' => $colocation->id,
            'name' => $request->name,
        ]);
        return back()->with('success', 'Catégorie ajoutée.');
    }

    public function invite(Request $request, Colocation $colocation)
    {
        $user = auth()->user();

        if ($colocation->owner_id !== $user->id) {
            return back()->with('error', 'Only the owner can invite.');
        }

        $request->validate([
            'email' => 'required|email',
        ]);

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $request->email,
            'token' => Str::uuid(),
            'status' => 'pending',
        ]);

        Mail::to($request->email)->send(new InvitationMail($invitation));

        return back()->with('success', 'Invitation sent.');
    }

    public function leave(Colocation $colocation)
    {
        $user = auth()->user();

        if ($colocation->owner_id === $user->id) {
            return back()->with('error', 'Owner cannot leave. Cancel the colocation instead.');
        }

        $balance = (new BalanceService)->getUserBalance($colocation, $user->id);

        if ($balance < 0) {
            $user->decrement('reputation_score');
        } else {
            $user->increment('reputation_score');
        }

        $colocation->members()->updateExistingPivot($user->id, ['left_at' => now()]);

        return redirect()->route('dashboard')->with('success', 'You have left the colocation.');
    }

    public function cancel(Colocation $colocation)
    {
        $user = auth()->user();

        if ($colocation->owner_id !== $user->id) {
            return back()->with('error', 'Only the owner can cancel.');
        }

        $balance = (new BalanceService)->getUserBalance($colocation, $user->id);

        if ($balance < 0) {
            $user->decrement('reputation_score');
        } else {
            $user->increment('reputation_score');
        }

        $colocation->update(['status' => 'cancelled']);

        return redirect()->route('dashboard')->with('success', 'Colocation cancelled.');
    }

    public function removeMember(Colocation $colocation, $memberId)
    {
        /** @var \App\Models\User $owner */
        $owner = auth()->user();
        $member = \App\Models\User::findOrFail($memberId);

        if ($colocation->owner_id !== $owner->id) {
            return back()->with('error', 'Only the owner can remove members.');
        }

        $balance = (new BalanceService)->getUserBalance($colocation, $member->id);

        if ($balance < 0) {
            $owner->decrement('reputation_score');

            // Transfer debt to owner
            \App\Models\Payment::create([
                'colocation_id' => $colocation->id,
                'from_user_id' => $owner->id,
                'to_user_id' => $member->id,
                'amount' => abs($balance),
            ]);
        } else {
            $member->increment('reputation_score');
        }

        $colocation->members()->updateExistingPivot($member->id, ['left_at' => now()]);

        return back()->with('success', 'Member removed.');
    }
}