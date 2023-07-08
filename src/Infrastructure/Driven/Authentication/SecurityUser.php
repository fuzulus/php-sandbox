<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Authentication;

use App\Domain\Authentication\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class SecurityUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(private readonly User $user)
    {
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->user->email();
    }

    public function getPassword(): ?string
    {
        return (string) $this->user->password();
    }

    public function domainUser(): User
    {
        return $this->user;
    }
}
