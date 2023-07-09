<?php

declare(strict_types=1);

namespace App\Domain\Authentication\VO;

use Assert\Assertion;

final class Password
{
    public function __construct(private readonly string $password)
    {
        // todo: add Domain exception
        Assertion::notEmpty($password);
    }

    public function __toString(): string
    {
        return $this->password;
    }
}
