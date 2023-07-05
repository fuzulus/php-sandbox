<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Persistence\Doctrine\DatabaseIdentifier;

use App\Domain\Common\Id;
use App\Domain\Pokemon\PokemonId;

final class PokemonIdType extends IdType
{
    public function getName(): string
    {
        return 'pokemonId';
    }

    protected function getIdClass(): string
    {
        return PokemonId::class;
    }

    protected function createIdFromString(string $value): Id
    {
        return PokemonId::fromString($value);
    }

    protected function isValid(string $value): bool
    {
        return PokemonId::isValid($value);
    }
}
