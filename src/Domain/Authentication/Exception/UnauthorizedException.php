<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Exception;

final class UnauthorizedException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('User unauthorized.');
    }
}
