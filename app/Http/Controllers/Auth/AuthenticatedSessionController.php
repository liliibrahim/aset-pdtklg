<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Papar borang login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login + validation domain
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validasi domain email
        $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with(strtolower($value), '@selangor.gov.my')) {
                        $fail('Emel mesti menggunakan domain @selangor.gov.my.');
                    }
                },
            ],
            'password' => 'required',
        ]);

        // Authenticate guna Breeze
        $request->authenticate();

        // Regenerate session utk keselamatan
        $request->session()->regenerate();

         // Redirect pengguna ikut role
        $user = $request->user();

        if ($user->role === 'admin_system') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'ict') {
            return redirect()->route('ict.dashboard');
        }

        // fallback untuk user lain
        return redirect()->route('dashboard');
    }

    /**
     * Log keluar
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
