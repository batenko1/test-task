<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create (User $user) {

        return true;
    }
    public function edit (User $user, Task $task) {
        return $user->id == $task->user_id;
    }
    public function update (User $user, Task $task) {
        return $user->id == $task->user_id;
    }
    public function delete (User $user, Task $task) {
        return $user->id == $task->user_id;
    }

}
