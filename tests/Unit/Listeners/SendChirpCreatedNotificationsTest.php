<?php

namespace Tests\Unit\Listeners;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewChirp;
use App\Models\User;
use App\Models\Chirp;

class SendChirpCreatedNotificationsTest extends TestCase
{
    /**
     * Test that a user's chirps are returned correctly.
     */
    public function test_chirp_posting_notifications_are_sent_to_correct_users(): void
    {
        Notification::fake();
        $user = $this->loggedInUser();
        $subscriber = User::factory()->create();
        $user->subscribedToMe()->attach($subscriber);
        $separate = User::factory()->create();
        $separate->subscribedToByMe()->attach($subscriber);
        $chirp = Chirp::factory()->for($user)->create();

        Notification::assertCount(1);
        Notification::assertSentTo(
            $subscriber,
            function (NewChirp $notification) use ($chirp) {
                return $notification->chirp->is($chirp);
            }
        );
    }
}
