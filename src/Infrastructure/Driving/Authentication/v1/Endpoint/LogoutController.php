<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Authentication\v1\Endpoint;

use LogicException;
use Symfony\Component\Routing\Annotation\Route;

final class LogoutController
{
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
