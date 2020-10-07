<?php

namespace App\DBAL\Model\User;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserNotFoundException;
use App\Domain\Model\User\UserRepository;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Drift\DBAL\Connection;
use Drift\DBAL\Result;
use React\Promise\PromiseInterface;

class DBALUserRepository implements UserRepository
{
    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * DBALUserRepository constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public function get(string $id): PromiseInterface
    {
        return $this
            ->connection
            ->findOneBy('users', [
                'id' => $id
            ])
            ->then(function (?array $user): User {
                if (!$user){
                    throw new UserNotFoundException();
                }

                return new User($user['id'], $user['name']);
            });
    }

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function delete(string $id): PromiseInterface
    {
        return $this
            ->connection
            ->delete('users', [
                'id' => $id
            ])
            ->then(function (Result $result){
                if ($result->getAffectedRows() !== 1){
                    throw new UserNotFoundException();
                }
            });
    }

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function put(User $user): PromiseInterface
    {
        $values = $user->jsonSerialize();
        unset($values['id']);
        return $this
            ->connection
            ->upsert('users', ['id' => $user->getId()], $values)
            ->then(function (Result $result){
                if ($result->getAffectedRows() !== 1){
                    throw new UserNotFoundException();
                }
            });
    }
}
