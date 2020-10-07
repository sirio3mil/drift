<?php

namespace Tests\DBAL\Model\User;

use App\DBAL\Model\User\DBALUserRepository;
use App\Domain\Model\User\UserRepository;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\DBAL\Exception\TableExistsException;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Drift\DBAL\Connection;
use Drift\DBAL\Credentials;
use Drift\DBAL\Driver\SQLite\SQLiteDriver;
use React\EventLoop\LoopInterface;
use Tests\Domain\Model\User\UserRepositoryTest;

class DBALUserRepositoryTest extends UserRepositoryTest
{
    /**
     * @param LoopInterface $loop
     * @return UserRepository
     * @throws InvalidArgumentException
     * @throws TableExistsException
     */
    protected function getEmptyRepository(LoopInterface $loop): UserRepository
    {
        $platform = new SqlitePlatform();
        $driver = new SQLiteDriver($loop);
        $credentials = new Credentials("", "", "root", "root", ":memory:");
        $connection = Connection::createConnected($driver, $credentials, $platform);
        $connection->createTable("users", [
            'id' => 'string',
            'name' => 'string'
        ]);
        return new DBALUserRepository($connection);
    }
}
