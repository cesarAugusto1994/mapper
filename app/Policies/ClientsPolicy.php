<?php

namespace App\Policies;

use App\User;
use App\App\Models\Clients;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the clients.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Clients  $clients
     * @return mixed
     */
    public function view(User $user, Clients $clients)
    {
        return $user->hasPermission('view.clientes');
    }

    /**
     * Determine whether the user can create clients.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create.clientes');
    }

    /**
     * Determine whether the user can update the clients.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Clients  $clients
     * @return mixed
     */
    public function update(User $user, Clients $clients)
    {
        return $user->hasPermission('edit.clientes');
    }

    /**
     * Determine whether the user can delete the clients.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Clients  $clients
     * @return mixed
     */
    public function delete(User $user, Clients $clients)
    {
        return $user->hasPermission('delete.clientes');
    }
}
