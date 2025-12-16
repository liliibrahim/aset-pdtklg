<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LogLoginActivity
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        logActivity('Login Sistem');
    }
}
