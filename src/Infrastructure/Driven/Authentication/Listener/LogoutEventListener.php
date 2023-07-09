<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Authentication\Listener;

use League\Bundle\OAuth2ServerBundle\Service\CredentialsRevokerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

final class LogoutEventListener
{
    public function __construct(
        private readonly CredentialsRevokerInterface $credentialsRevoker,
        private readonly Security $security,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function onSymfonyComponentSecurityHttpEventLogoutEvent(LogoutEvent $event): void
    {
        /** @var string $redirectUri */
        $redirectUri = $event->getRequest()->get('redirect_uri', '');

        if (false === empty($redirectUri)) {
            $event->setResponse(new RedirectResponse($redirectUri));
        } else {
            $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_login')));
        }

        $user = $this->security->getUser();

        if (null !== $user) {
            $this->credentialsRevoker->revokeCredentialsForUser($user);
        }
    }
}
