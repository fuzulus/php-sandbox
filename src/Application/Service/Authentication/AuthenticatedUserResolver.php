<?php

declare(strict_types=1);

namespace App\Application\Service\Authentication;

use App\Domain\Authentication\Exception\UnauthorizedException;
use App\Domain\Authentication\User;

interface AuthenticatedUserResolver
{
    /** @throws UnauthorizedException */
    public function authenticatedUser(): User;
}
