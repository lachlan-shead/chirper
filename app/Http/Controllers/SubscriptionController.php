<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{
    /**
     * Subscribe to a user's chirps.
     */
    public function store(User $user): Response
    {
        if (! Gate::allows('subscribe', $user)) {
            abort(403);
        }

        return response('Subscribe time!');
    }

    /**
     * Unsubscribe from a user's chirps.
     */
    public function destroy(User $user): Response
    {
        if (! Gate::allows('unsubscribe', $user)) {
            abort(403);
        }

        return response('Unsubscribe time!');
    }
}
