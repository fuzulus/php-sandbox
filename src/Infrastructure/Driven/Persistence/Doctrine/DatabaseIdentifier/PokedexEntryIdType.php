<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Persistence\Doctrine\DatabaseIdentifier;

use App\Domain\Common\Id;
use App\Domain\Pokedex\PokedexEntryId;

final class PokedexEntryIdType extends IdType
{
    public function getName(): string
    {
        return 'pokedexEntryId';
    }

    protected function getIdClass(): string
    {
        return PokedexEntryId::class;
    }

    protected function createIdFromString(string $value): Id
    {
        return PokedexEntryId::fromString($value);
    }

    protected function isValid(string $value): bool
    {
        return PokedexEntryId::isValid($value);
    }
}
