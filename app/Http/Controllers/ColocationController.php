<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ColocationController extends Controller
{
    public function leave(Colocation $colocation){
        $user = auth()->user();
        if($colocation ->owner_id === $user->id){
            return back()->with('error','Owner cannot leave. Cancel the colocation instead');
        }
        $colocation->members()->updateExistingPivot($user->id,[
            'left_at' => now(),
        ]);
        return redirect()->route('dashboard')->with('success','You have left the colocation');
    }

    public function cancel(Colocation $colocation){
        $user = auth()->user();
        if($colocation -> owner_id !== $user->id){
            return back()->with('error','Only the owner cancel');
        }
        $colocation ->update(['status' => 'cancelled']);
        return redirect()->route('dashboard')->with('success','Colocation cancelled');
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

    // Block if user already has active colocation
    $alreadyMember = $user->colocations()
                          ->wherePivotNull('left_at')
                          ->where('status', 'active')
                          ->exists();

    if ($alreadyMember) {
        return back()->with('error', 'You already have an active colocation.');
    }

    $colocation = Colocation::create([
        'name'     => $request->name,
        'status'   => 'active',
        'owner_id' => $user->id,
    ]);

    // Add owner as member
    $colocation->members()->attach($user->id, [
        'role'      => 'owner',
        'joined_at' => now(),
    ]);

    return redirect()->route('colocations.show', $colocation)->with('success', 'Colocation created.');
}

public function show(Colocation $colocation)
{
    return view('colocations.show', compact('colocation'));
}

public function invite(Request $request, Colocation $colocation)
{
    /** @var \App\Models\User $user */
    $user = auth()->user();

    if ($colocation->owner_id !== $user->id) {
        return back()->with('error', 'Only the owner can invite.');
    }

    $request->validate([
        'email' => 'required|email',
    ]);

    $invitation = Invitation::create([
        'colocation_id' => $colocation->id,
        'email'         => $request->email,
        'token'         => Str::uuid(),
        'status'        => 'pending',
    ]);

    Mail::to($request->email)->send(new InvitationMail($invitation));

    return back()->with('success', 'Invitation sent.');
}
}
