<?php

namespace App\Policies;

use App\TimeSlot;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimeSlotPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any time slots.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the time slot.
     *
     * @param  \App\User  $user
     * @param  \App\TimeSlot  $timeSlot
     * @return mixed
     */
    public function view(User $user, TimeSlot $timeSlot)
    {
        //
    }

    /**
     * Determine whether the user can create time slots.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the time slot.
     *
     * @param  \App\User  $user
     * @param  \App\TimeSlot  $timeSlot
     * @return mixed
     */
    public function update(User $user, TimeSlot $timeSlot)
    {
        //
    }

    /**
     * Determine whether the user can delete the time slot.
     *
     * @param  \App\User  $user
     * @param  \App\TimeSlot  $timeSlot
     * @return mixed
     */
    public function delete(User $user, TimeSlot $timeSlot)
    {
        //
    }

    /**
     * Determine whether the user can restore the time slot.
     *
     * @param  \App\User  $user
     * @param  \App\TimeSlot  $timeSlot
     * @return mixed
     */
    public function restore(User $user, TimeSlot $timeSlot)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the time slot.
     *
     * @param  \App\User  $user
     * @param  \App\TimeSlot  $timeSlot
     * @return mixed
     */
    public function forceDelete(User $user, TimeSlot $timeSlot)
    {
        //
    }
}
