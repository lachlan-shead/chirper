<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Chirp;

class UserTest extends TestCase
{
    /**
     * Test that a user's chirps are returned correctly.
     */
    public function test_user_chirps_method_gets_right_records(): void
    {
        $userWithNoChirps = User::factory()->create();
        $userPostingChirps = $this->loggedInUser();
        $chirp1 = Chirp::factory()->for($userPostingChirps)->create();
        $chirp2 = Chirp::factory()->for($userPostingChirps)->create();

        $this->assertEquals(0, $userWithNoChirps->chirps()->count());
        $this->assertEquals(2, $userPostingChirps->chirps()->count());
        $this->assertTrue($userPostingChirps->chirps->contains($chirp1));
        $this->assertTrue($userPostingChirps->chirps->contains($chirp2));
    }

    /**
     * Test that the users the current one is subscribed to are returned correctly.
     */
    public function test_user_subscribed_to_by_me_list_gets_right_records(): void
    {
        $user = User::factory()->create();
        $subscribedTo = User::factory()->create();
        $subscribedBothWays = User::factory()->create();
        $user->subscribedToByMe()->attach($subscribedTo);
        $user->subscribedToByMe()->attach($subscribedBothWays);
        $subscribedBothWays->subscribedToByMe()->attach($user);

        $this->assertEquals(2, $user->subscribedToByMe()->count());
        $this->assertTrue($user->subscribedToByMe->contains($subscribedTo));
        $this->assertTrue($user->subscribedToByMe->contains($subscribedBothWays));
        $this->assertEquals(1, $subscribedBothWays->subscribedToByMe()->count());
        $this->assertTrue($subscribedBothWays->subscribedToByMe->contains($user));
        $this->assertEquals(0, $subscribedTo->subscribedToByMe()->count());
    }

    /**
     * Test that the users the current one is subscribed to are returned correctly.
     */
    public function test_user_subscribed_to_me_list_gets_right_records(): void
    {
        $user = User::factory()->create();
        $subscribedTo = User::factory()->create();
        $subscribedBothWays = User::factory()->create();
        $user->subscribedToByMe()->attach($subscribedTo);
        $user->subscribedToByMe()->attach($subscribedBothWays);
        $subscribedBothWays->subscribedToByMe()->attach($user);

        $this->assertEquals(1, $user->subscribedToMe()->count());
        $this->assertTrue($user->subscribedToMe->contains($subscribedBothWays));
        $this->assertEquals(1, $subscribedTo->subscribedToMe->count());
        $this->assertTrue($subscribedTo->subscribedToMe->contains($user));
        $this->assertEquals(1, $subscribedBothWays->subscribedToByMe()->count());
        $this->assertTrue($subscribedBothWays->subscribedToMe->contains($user));
    }
}
