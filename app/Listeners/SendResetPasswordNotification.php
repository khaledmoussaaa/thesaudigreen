<?php

namespace App\Listeners;

use App\Events\NewAccountCreate;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendResetPasswordNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewAccountCreate $event): void
    {
        $event->user->notify(new ResetPasswordNotification($event->token));
    }
}
