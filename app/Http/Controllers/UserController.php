<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * AJAX: unit ikut bahagian (fungsi lama – kekal)
     */
    public function getUnitsByBahagian($bahagianId)
    {
        return response()->json(
            Unit::where('bahagian_id', $bahagianId)
                ->select('id', 'nama')
                ->get()
        );
    }

    /**
     * Senarai pengguna
     * ✔ Admin: papar SEMUA pengguna
     */
    public function index(Request $request)
{
    $query = User::with(['bahagian', 'unit']);

    // 🔍 SEARCH
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('role', 'like', "%{$search}%");
        });
    }

    $users = $query->orderBy('name')->get();

    return view('admin.users.index', compact('users'));
}


    /**
     * Papar borang create (placeholder – kekal)
     */
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        return redirect()->back()->with('success', 'User created (placeholder)');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * EDIT PENGGUNA
     * ✔ Admin boleh edit role
     * ✔ Fungsi lama kekal
     */
    public function edit(User $user)
    {
        if (Auth::user()->role === 'admin' && view()->exists('admin.users.edit')) {
            return view('admin.users.edit', compact('user'));
        }

        return view('users.edit', compact('user'));
    }

    /**
     * UPDATE PENGGUNA
     * ✔ Admin boleh tukar role
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->role === 'admin' && $request->has('role')) {

            $request->validate([
                'role' => 'in:admin,ict,user',
            ]);

            $user->role = $request->role;
            $user->save();

            logActivity('Kemaskini Peranan Pengguna: ' . $user->name);

            return redirect()->back()
                ->with('success', 'Peranan pengguna dikemaskini.');
        }

        return redirect()->back()
            ->with('success', 'User updated (placeholder)');
    }

    public function destroy(User $user)
    {
        return redirect()->back()
            ->with('success', 'User deleted (placeholder)');
    }

    public function resetPassword(User $user)
    {
        $user->password = bcrypt('password123');
        $user->save();

        logActivity('Reset Kata Laluan Pengguna');

        return back()->with('success', 'Kata laluan telah direset');
    }

    /**
     * Senarai Pentadbir Sistem
     */
    public function admins()
    {
        $users = User::where('role', 'admin')
            ->with(['bahagian', 'unit'])
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Senarai Pegawai ICT
     */
    public function ict()
    {
        $users = User::where('role', 'ict')
            ->with(['bahagian', 'unit'])
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }
}
