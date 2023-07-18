<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    /**
     * Subscribe to a user's chirps.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->subscribe_to_user_id);

        if (! Gate::allows('subscribe', $user)) {
            abort(403);
        }

        $request->user()->subscribedToByMe()->attach($user->id);

        return redirect(route('chirps.index'));
    }

    /**
     * Unsubscribe from a user's chirps.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if (! Gate::allows('unsubscribe', $user)) {
            abort(403);
        }

        $request->user()->subscribedToByMe()->detach($user->id);

        return redirect(route('chirps.index'));
    }
}
