<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class LogLogoutActivity
{
    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        logActivity('Logout Sistem');
    }
}
