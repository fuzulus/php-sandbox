<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Persistence\Doctrine\DatabaseIdentifier;

use App\Domain\Authentication\UserId;
use App\Domain\Common\Id;

final class UserIdType extends IdType
{
    public function getName(): string
    {
        return 'userId';
    }

    protected function getIdClass(): string
    {
        return UserId::class;
    }

    protected function createIdFromString(string $value): Id
    {
        return UserId::fromString($value);
    }

    protected function isValid(string $value): bool
    {
        return UserId::isValid($value);
    }
}
