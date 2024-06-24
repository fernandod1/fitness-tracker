<?php

namespace App\Listeners;

use App\Events\ActivityCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewActivityAdded;

class SendPersonalTotalGoals
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
    public function handle(ActivityCreated $event): void
    {
        Mail::to(auth()->user()->email)->send(new NewActivityAdded($event->activityService));
    }
}
