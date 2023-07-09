<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Exception;

use App\Domain\Authentication\VO\Email;

final class UserNotFoundException extends \DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function byEmail(Email $email): self
    {
        return new self(sprintf('User with e-mail %s not found', (string) $email));
    }
}
