<?php

namespace Tests\Unit\Policies;

use Tests\TestCase;
use App\Models\User;
use App\Models\Chirp;
use App\Policies\ChirpPolicy;

class ChirpPolicyTest extends TestCase
{

    /**
     * Test the correctness of update policy.
     */
    public function test_chirp_update_policy_is_correct(): void
    {
        $policy = app(ChirpPolicy::class);
        $user = $this->loggedInUser();
        $userAuthoredChirp = Chirp::factory()->for($user)->create();
        $differentUserChirp = Chirp::factory()->for(User::factory()->create())->create();

        $this->assertTrue($policy->update($user, $userAuthoredChirp));
        $this->assertFalse($policy->update($user, $differentUserChirp));
    }

    /**
     * Test the correctness of delete policy.
     */
    public function test_chirp_delete_policy_is_correct(): void
    {
        $policy = app(ChirpPolicy::class);
        $user = $this->loggedInUser();
        $userAuthoredChirp = Chirp::factory()->for($user)->create();
        $differentUserChirp = Chirp::factory()->create();

        $this->assertTrue($policy->delete($user, $userAuthoredChirp));
        $this->assertFalse($policy->delete($user, $differentUserChirp));
    }
}
