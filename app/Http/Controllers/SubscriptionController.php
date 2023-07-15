<?php

namespace App\Http\Controllers;

use App\Models\User;

class SubscriptionController extends Controller
{
    /**
     * Subscribe to a user's chirps.
     */
    public function subscribe(User $user): void
    {
        $this->authorize('subscribe', $user);
    }

    /**
     * Unsubscribe from a user's chirps.
     */
    public function unsubscribe(User $user): void
    {
        $this->authorize('unsubscribe', $user);
    }
}
