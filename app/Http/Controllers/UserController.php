<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->route('dashboard.users.index')->with('success', 'نقش کاربر با موفقیت به‌روزرسانی شد.');
    }

}
