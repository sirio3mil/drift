<?php

namespace App\Domain\QueryHandler;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserNotFoundException;
use App\Domain\Model\User\UserRepository;
use App\Domain\Query\GetUser;
use React\Promise\PromiseInterface;

class GetUserHandler
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * GetUserHandler constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param GetUser $getUser
     *
     * @return PromiseInterface<User, UserNotFoundException>
     */
    public function handle(GetUser $getUser): PromiseInterface
    {
        return $this->userRepository->get($getUser->getId());
    }
}
