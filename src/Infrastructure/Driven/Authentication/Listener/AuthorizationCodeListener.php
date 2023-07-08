<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Authentication\Listener;

use League\Bundle\OAuth2ServerBundle\Event\AuthorizationRequestResolveEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class AuthorizationCodeListener
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function onAuthorizationRequestResolve(AuthorizationRequestResolveEvent $event): void
    {
        if (null === $event->getUser()) {
            $request = $this->requestStack->getMainRequest();

            $event->setResponse(
                new RedirectResponse(
                    $this->urlGenerator->generate(
                        'app_login',
                        [
                            'returnUrl' => $request?->getUri(),
                        ],
                    ),
                ),
            );

            return;
        }

        $event->resolveAuthorization(AuthorizationRequestResolveEvent::AUTHORIZATION_APPROVED);
    }
}
