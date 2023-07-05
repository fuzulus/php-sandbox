<?php

declare(strict_types=1);

namespace App\Domain\Common\Exception;

final class InvalidIdentityException extends \Exception
{
    public function __construct(string $identifier)
    {
        parent::__construct(sprintf('Invalid identity: %s', $identifier));
    }
}
