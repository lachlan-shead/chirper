<?php

namespace App\Policies;

use App\Models\User;

class SubscriptionPolicy
{
    /**
     * Determine whether the user can subscribe to another.
     */
    public function store(User $user, User $model): bool
    {
        return ! $user->is($model) && ! $user->subscribedToByMe()->where('subscribed_to_id', $model->id)->exists();
    }

    /**
     * Determine whether the user can unsubscribe from another.
     */
    public function destroy(User $user, User $model): bool
    {
        return $user->subscribedToByMe()->where('subscribed_to_id', $model->id)->exists();
    }
}
