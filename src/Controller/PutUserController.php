<?php

namespace App\Controller;

use App\Domain\Command\PutUser;
use App\Domain\Model\User\User;
use App\Domain\Model\User\UserNotFoundException;
use Drift\CommandBus\Bus\CommandBus;
use Drift\CommandBus\Exception\InvalidCommandException;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use function json_decode;

class PutUserController
{
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * PutUserController constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @return PromiseInterface
     * @throws InvalidCommandException
     */
    public function __invoke(Request $request): PromiseInterface
    {
        $data = json_decode($request->getContent(), true);

        $user = new User($data['id'], $data['name']);
        $putUser = new PutUser($user);

        return $this
            ->commandBus
            ->execute($putUser)
            ->then(function (): JsonResponse {
                return new JsonResponse(null, JsonResponse::HTTP_CREATED);
            })
            ->otherwise(function (UserNotFoundException $exception): JsonResponse {
                return new JsonResponse($exception, JsonResponse::HTTP_BAD_REQUEST);
            });
    }
}
