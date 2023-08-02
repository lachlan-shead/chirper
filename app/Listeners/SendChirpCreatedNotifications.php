<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Notifications\NewChirp;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;

class SendChirpCreatedNotifications implements ShouldQueue
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
    public function handle(ChirpCreated $event): void
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        foreach($user->subscribedToMe()->cursor() as $subscriber) {
            $subscriber->notify(new NewChirp($event->chirp));
        }
    }
}
