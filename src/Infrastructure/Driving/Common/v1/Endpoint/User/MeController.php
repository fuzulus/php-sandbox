<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Endpoint\User;

use App\Application\Service\Authentication\AuthenticatedUserResolver;
use App\Infrastructure\Driving\Common\v1\ApiResponder\ResourceResponder;
use Symfony\Component\Routing\Annotation\Route;
use Undabot\SymfonyJsonApi\Http\Model\Response\ResourceResponse;

final class MeController
{
    #[Route(path: '/me', name: 'api.v1.common.users.me', methods: 'GET')]
    public function me(
        AuthenticatedUserResolver $authenticatedUserResolver,
        ResourceResponder $resourceResponder,
    ): ResourceResponse {
        return $resourceResponder->resource(
            $authenticatedUserResolver
                ->authenticatedUser()
                ->meViewModel()
        );
    }
}
