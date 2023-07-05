<?php

declare(strict_types=1);

namespace App\Domain\Authentication\VO;

use Assert\Assertion;

final class Email
{
    public function __construct(private readonly string $email)
    {
        // todo: add Domain exception
        Assertion::email($email);
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
