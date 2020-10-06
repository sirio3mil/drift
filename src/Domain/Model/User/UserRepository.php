<?php

namespace App\Domain\Model\User;

use React\Promise\PromiseInterface;

interface UserRepository
{
    /**
     * @param string $id
     *
     * @return PromiseInterface<User, UserNotFoundException>
     */
    public function get(string $id): PromiseInterface;

    /**
     * @param string $id
     *
     * @return PromiseInterface<void, UserNotFoundException>
     */
    public function delete(string $id): PromiseInterface;

    /**
     * @param User $user
     *
     * @return PromiseInterface<void>
     */
    public function put(User $user): PromiseInterface;
}
