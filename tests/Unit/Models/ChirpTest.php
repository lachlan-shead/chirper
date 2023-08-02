<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Chirp;

class ChirpTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_chirp_has_correct_user_assigned(): void
    {
        $user = $this->loggedInUser();
        $chirp = Chirp::factory()->for($user)->create();

        $this->assertTrue($user->is($chirp->user));
    }
}
