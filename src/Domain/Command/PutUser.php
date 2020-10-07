<?php

namespace App\Domain\Command;

use App\Domain\Model\User\User;

class PutUser
{
    /**
     * @var User
     */
    private User $user;

    /**
     * PutUser constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
