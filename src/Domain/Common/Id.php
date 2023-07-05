<?php

declare(strict_types=1);

namespace App\Domain\Common;

abstract class Id
{
    private const ID_LENGTH = 26;

    private function __construct(protected string $id)
    {
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $id): static
    {
        /** @psalm-suppress UnsafeInstantiation */
        return new static($id); // @phpstan-ignore-line
    }

    public function equalTo(self $id): bool
    {
        return (string) $this === (string) $id && static::class === \get_class($id);
    }

    public static function isValid(string $value): bool
    {
        return self::ID_LENGTH === mb_strlen($value);
    }
}
