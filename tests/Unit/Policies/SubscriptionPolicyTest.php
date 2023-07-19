<?php

namespace Tests\Unit\Policies;

use Tests\TestCase;
use App\Policies\SubscriptionPolicy;
use App\Models\User;

class SubscriptionPolicyTest extends TestCase
{
    /**
     * Test the correctness of subscription policy.
     */
    public function test_subscription_store_policy_is_correct(): void
    {
        $policy = app(SubscriptionPolicy::class);
        $user = $this->loggedInUser();
        $notSubscribedTo = User::factory()->create();
        $subscribedTo = User::factory()->create();
        $user->subscribedToByMe()->attach($subscribedTo);

        $this->assertFalse($policy->store($user, $user));
        $this->assertTrue($policy->store($user, $notSubscribedTo));
        $this->assertFalse($policy->store($user, $subscribedTo));
    }

    /**
     * Test the correctness of unsubscription policy.
     */
    public function test_subscription_destroy_policy_is_correct(): void
    {
        $policy = app(SubscriptionPolicy::class);
        $user = $this->loggedInUser();
        $notSubscribedTo = User::factory()->create();
        $subscribedTo = User::factory()->create();
        $user->subscribedToByMe()->attach($subscribedTo);

        $this->assertFalse($policy->destroy($user, $user));
        $this->assertFalse($policy->destroy($user, $notSubscribedTo));
        $this->assertTrue($policy->destroy($user, $subscribedTo));
    }
}
