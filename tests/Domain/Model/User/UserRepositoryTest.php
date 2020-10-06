<?php

namespace Tests\Domain\Model\User;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserNotFoundException;
use App\Domain\Model\User\UserRepository;
use Exception;
use function Clue\React\Block\await;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;

abstract class UserRepositoryTest extends TestCase
{
    abstract protected function getEmptyRepository(LoopInterface $loop): UserRepository;

    /**
     * @throws Exception
     */
    public function testGetUserOnEmptyRepository (){

        $loop = Factory::create();
        $userRepository = $this->getEmptyRepository($loop);

        $userPromise = $userRepository->get('123');

        $this->expectException(UserNotFoundException::class);
        await($userPromise,$loop);
    }

    /**
     * @throws Exception
     */
    public function testGetUserWhenExists(){

        $loop = Factory::create();
        $userRepository = $this->getEmptyRepository($loop);

        await ($userRepository->put(new User('123','Old')),$loop);
        await ($userRepository->put(new User('456','New')),$loop);

        $userPromise = $userRepository->get('123');

        $user = await ($userPromise,$loop);

        $this->assertEquals('123',$user->getId());
        $this->assertEquals('Old',$user->getName());
    }

    /**
     * @throws Exception
     */
    public function testPutExistingUser(){

        $loop = Factory::create();
        $userRepository = $this->getEmptyRepository($loop);

        await ($userRepository->put(new User('123','Pepe')),$loop);
        await ($userRepository->put(new User('123','Manuel')),$loop);

        $userPromise = $userRepository->get('123');

        $user = await ($userPromise,$loop);

        $this->assertEquals('123',$user->getId());
        $this->assertEquals('Manuel',$user->getName());

    }

    /**
     * @throws Exception
     */
    public function testDeleteExistingUser(){

        $loop = Factory::create();
        $userRepository = $this->getEmptyRepository($loop);

        await ($userRepository->put(new User('123','Pepe')),$loop);
        await ($userRepository->delete('123'),$loop);

        $userPromise = $userRepository->get('123');

        $this->expectException(UserNotFoundException::class);
        await($userPromise,$loop);
    }

    /**
     * @throws Exception
     */
    public function testDeleteNotExistingUser(){

        $loop = Factory::create();
        $userRepository = $this->getEmptyRepository($loop);

        $userPromise = $userRepository->delete('123');

        $this->expectException(UserNotFoundException::class);
        await($userPromise,$loop);
    }

}
