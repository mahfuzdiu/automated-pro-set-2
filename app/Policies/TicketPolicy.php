<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role == 'organizer' && $ticket->created_by == $user->id) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Event $event
     */
    public function delete(User $user, Ticket $ticket)
    {
        return $this->update($user, $ticket);
    }
}
