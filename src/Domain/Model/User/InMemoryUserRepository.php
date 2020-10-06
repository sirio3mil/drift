<?php

namespace App\Domain\Model\User;

use React\Promise\PromiseInterface;
use function React\Promise\reject;
use function React\Promise\resolve;

class InMemoryUserRepository implements UserRepository
{

    private array $data;

    public function __construct()
    {
        $this->data = [];
    }

    /**
     * @inheritDoc
     */
    public function get(string $id): PromiseInterface
    {
        if (empty($this->data[$id])) {
            reject(new UserNotFoundException());
        }

        return resolve($this->data[$id]);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $id): PromiseInterface
    {
        if (empty($this->data[$id])) {
            reject(new UserNotFoundException());
        }

        unset($this->data[$id]);
        return resolve();
    }

    /**
     * @inheritDoc
     */
    public function put(User $user): PromiseInterface
    {
        $this->data[$user->getId()] = $user;

        return resolve();
    }
}
