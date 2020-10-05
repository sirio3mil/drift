<?php

namespace App\Controller;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserNotFoundException;
use App\Domain\Query\GetUser;
use Drift\CommandBus\Bus\QueryBus;
use Drift\CommandBus\Exception\InvalidCommandException;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserController
{
    /**
     * @var QueryBus
     */
    private QueryBus $queryBus;

    /**
     * GetUserController constructor.
     *
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @param string $id
     *
     * @return mixed
     * @throws InvalidCommandException
     */
    public function __invoke(string $id)
    {
        $getUser = new GetUser($id);

        return $this->queryBus->ask($getUser)->then(
            function (User $user): JsonResponse {
                return new JsonResponse($user);
            }
        )->otherwise(
            function (UserNotFoundException $exception): JsonResponse {
                return new JsonResponse($exception, JsonResponse::HTTP_NOT_FOUND);
            }
        );
    }
}
