<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Gather stats
        $totalUsers = User::count();
        $totalColocations = Colocation::count();
        $totalExpenses = Expense::sum('amount');
        $bannedUsers = User::where('is_banned', true)->count();

        // Paginate users for the list
        $users = User::latest()->paginate(15);

        return view('admin.dashboard', compact('totalUsers', 'totalColocations', 'totalExpenses', 'bannedUsers', 'users'));
    }

    public function toggleBan(User $user)
    {
        // Prevent banning yourself if you are the current admin
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot ban yourself.');
        }

        $user->is_banned = !$user->is_banned;
        $user->save();

        $action = $user->is_banned ? 'banned' : 'unbanned';
        return back()->with('success', "User successfully {$action}.");
    }
}
