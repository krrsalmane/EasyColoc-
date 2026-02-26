<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function accept(string $token)
    {
        $user       = auth()->user();
        $invitation = Invitation::where('token', $token)
                                ->where('status', 'pending')
                                ->firstOrFail();

        // Check email matches
        if ($invitation->email !== $user->email) {
            return redirect()->route('dashboard')->with('error', 'This invitation is not for you.');
        }

        // Block if already in active colocation
        $alreadyMember = $user->colocations()
                              ->wherePivotNull('left_at')
                              ->where('status', 'active')
                              ->exists();

        if ($alreadyMember) {
            return redirect()->route('dashboard')->with('error', 'You already have an active colocation.');
        }

        $invitation->update(['status' => 'accepted']);

        $invitation->colocation->members()->attach($user->id, [
            'role'      => 'member',
            'joined_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'You joined the colocation.');
    }

    public function refuse(string $token)
    {
        $invitation = Invitation::where('token', $token)
                                ->where('status', 'pending')
                                ->firstOrFail();

        $invitation->update(['status' => 'refused']);

        return redirect()->route('dashboard')->with('success', 'Invitation refused.');
    }
}