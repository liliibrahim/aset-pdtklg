<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    // Kendalikan proses pengesahan email pengguna.
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Jika email telah disahkan, terus redirect ke dashboard
        if ($user->hasVerifiedEmail()) {
            return redirect()
                ->intended(route('dashboard', absolute: false) . '?verified=1');
        }

        // Mark email sebagai verified dan trigger event
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        // Redirect ke dashboard selepas pengesahan berjaya
        return redirect()
            ->intended(route('dashboard', absolute: false) . '?verified=1');
    }
}
