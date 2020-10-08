<?php

namespace App\Domain\Event;

use App\Domain\Model\User\User;

class UserWasPut
{
    /**
     * @var User
     */
    private User $user;

    /**
     * UserWasPut constructor.
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
