<?php

namespace App\Policies;

use App\Models\User;

class SubscriptionPolicy
{
    /**
     * Determine whether the user can subscribe to another.
     */
    public function subscribe(User $auth, User $user): bool
    {
        return ! $auth->isSubscribedTo()->where('subscribed_to_id', $user)->exists();
    }

    /**
     * Determine whether the user can unsubscribe from another.
     */
    public function unsubscribe(User $auth, User $user): bool
    {
        return $auth->isFollowing()->where('subscribed_to_id', $user)->exists();
    }
}
