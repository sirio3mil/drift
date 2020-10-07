<?php

namespace App\Domain\CommandHandler;

use App\Domain\Command\PutUser;
use App\Domain\Model\User\UserNotFoundException;
use App\Domain\Model\User\UserRepository;
use React\Promise\PromiseInterface;

class PutUserHandler
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
     * @param PutUser $putUser
     *
     * @return PromiseInterface<void, UserNotFoundException>
     */
    public function handle(PutUser $putUser): PromiseInterface
    {
        return $this->userRepository->put($putUser->getUser());
    }
}
