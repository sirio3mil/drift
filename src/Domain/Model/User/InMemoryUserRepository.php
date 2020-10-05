<?php

namespace App\Domain\Model\User;

use React\Promise\PromiseInterface;

class InMemoryUserRepository implements UserRepository
{

    /**
     * @inheritDoc
     */
    public function get(string $id): PromiseInterface
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(string $id): PromiseInterface
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritDoc
     */
    public function put(User $id): PromiseInterface
    {
        // TODO: Implement put() method.
    }
}
