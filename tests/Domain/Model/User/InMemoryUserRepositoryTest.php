<?php

namespace Tests\Domain\Model\User;

use App\Domain\Model\User\InMemoryUserRepository;
use App\Domain\Model\User\UserRepository;
use React\EventLoop\LoopInterface;

class InMemoryUserRepositoryTest extends UserRepositoryTest
{

    protected function getEmptyRepository(LoopInterface $loop): UserRepository
    {
        return new InMemoryUserRepository();
    }
}
