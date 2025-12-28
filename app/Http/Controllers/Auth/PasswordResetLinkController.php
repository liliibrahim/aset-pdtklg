<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Paparkan borang permohonan reset kata laluan.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Kendalikan permintaan penghantaran reset password link.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi alamat email pengguna
        $request->validate([
            'email' => ['required', 'email'],
        ]);

         // Hantar reset password link menggunakan Password facade.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Papar maklum balas berdasarkan status penghantaran
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
