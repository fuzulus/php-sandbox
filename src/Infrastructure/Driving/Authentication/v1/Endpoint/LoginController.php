<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Authentication\v1\Endpoint;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

final class LoginController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(
        Environment $twig,
        AuthenticationUtils $authenticationUtils
    ): Response {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return new Response(
            $twig->render(
                'Authentication/login.html.twig',
                [
                    'error' => $error,
                    'lastUsername' => $lastUsername,
                ],
            ),
        );
    }
}
