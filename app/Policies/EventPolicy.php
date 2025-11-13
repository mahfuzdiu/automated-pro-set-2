<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function update(User $user, Event $event): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role == 'organizer' && $event->created_by == $user->id) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Event $event
     */
    public function delete(User $user, Event $event)
    {
        return $this->update($user, $event);
    }
}
