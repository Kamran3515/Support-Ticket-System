<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSupport() || $user->isAdmin();
    }

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id
            || $user->isSupport()
            || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return true; // همه کاربران احراز شده
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->isSupport() || $user->isAdmin();
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin();
    }

    public function assign(User $user, Ticket $ticket): bool
    {
        return $user->isSupport() || $user->isAdmin();
    }
}
