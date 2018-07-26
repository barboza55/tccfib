<?php

namespace App\Policies;

use App\User;
use App\Model\Panel\Country;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the country.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Panel\Country  $country
     * @return mixed
     */
    public function view(User $user, Country $country)
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can create countries.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('criarPais');
    }

    /**
     * Determine whether the user can update the country.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Panel\Country  $country
     * @return mixed
     */
    public function update(User $user, Country $country)
    {
        //
    }

    /**
     * Determine whether the user can delete the country.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Panel\Country  $country
     * @return mixed
     */
    public function delete(User $user, Country $country)
    {
        //
    }
}
