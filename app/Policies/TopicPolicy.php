<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Topic $topic
     * @return mixed
     */
    public function update(User $user, Topic $topic)
    {
        return $user->id == $topic->user_id;
    }

    /**
     * @param User $user
     * @param Topic $topic
     * @return mixed
     */
    public function delete(User $user, Topic $topic)
    {
        return $user->id == $topic->user_id;
    }
}
