<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Authentication;

use App\Application\Repository\Authentication\UserReadRepository;
use App\Domain\Authentication\VO\Email;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    public function __construct(private readonly UserReadRepository $userReadRepository)
    {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return SecurityUser::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return new SecurityUser($this->userReadRepository->findByEmail(new Email($identifier)));
    }
}
