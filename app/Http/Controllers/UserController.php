<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Senarai user
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Page create user
    public function create()
    {
        return view('users.create');
    }

    // Simpan user baharu
    public function store(Request $request)
    {
        return redirect()->back()->with('success', 'User created (placeholder)');
    }

    // Papar user
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Edit user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        return redirect()->back()->with('success', 'User updated (placeholder)');
    }

    // Delete user
    public function destroy(User $user)
    {
        return redirect()->back()->with('success', 'User deleted (placeholder)');
    }
}
