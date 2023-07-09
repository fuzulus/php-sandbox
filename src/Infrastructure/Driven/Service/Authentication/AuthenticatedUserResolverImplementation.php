<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Service\Authentication;

use App\Application\Service\Authentication\AuthenticatedUserResolver;
use App\Domain\Authentication\Exception\UnauthorizedException;
use App\Domain\Authentication\User;
use App\Infrastructure\Driven\Authentication\SecurityUser;
use Symfony\Bundle\SecurityBundle\Security;

final class AuthenticatedUserResolverImplementation implements AuthenticatedUserResolver
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    public function authenticatedUser(): User
    {
        $securityUser = $this->security->getUser();

        if (
            null === $securityUser
            || false === ($securityUser instanceof SecurityUser)
        ) {
            throw new UnauthorizedException();
        }

        return $securityUser->domainUser();
    }
}
