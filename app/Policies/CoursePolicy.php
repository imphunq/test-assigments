<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
    }

    public function viewThreads(User $user, Course $course)
    {
        $users = $course->users;
        $instructor = $course->instructor;

        return $users->contains($user->id) || $instructor->id === $user->id;
    }

    public function create(User $user)
    {
        return $user->role === User::INSTRUCTORS;
    }

    public function delete(User $user, Course $course)
    {
        return $user->id === $course->user_id || $user->role === User::ADMIN;
    }
}
