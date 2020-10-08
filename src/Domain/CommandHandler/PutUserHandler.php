<?php

namespace App\Domain\CommandHandler;

use App\Domain\Command\PutUser;
use App\Domain\Event\UserWasPut;
use App\Domain\Model\User\UserNotFoundException;
use App\Domain\Model\User\UserRepository;
use Drift\EventBus\Bus\EventBus;
use React\Promise\PromiseInterface;

class PutUserHandler
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var EventBus
     */
    private EventBus $eventBus;

    /**
     * GetUserHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param EventBus $eventBus
     */
    public function __construct(UserRepository $userRepository, EventBus $eventBus)
    {
        $this->userRepository = $userRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param PutUser $putUser
     *
     * @return PromiseInterface<void, UserNotFoundException>
     */
    public function handle(PutUser $putUser): PromiseInterface
    {
        $user = $putUser->getUser();
        return $this
            ->userRepository
            ->put($user)
            ->then(function () use ($user){
                $event = new UserWasPut($user);
                return $this->eventBus->dispatch($event);
            });
    }
}
