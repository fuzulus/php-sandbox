<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\ParamConverter;

use App\Domain\Pokedex\PokedexEntryId;

final class PokedexEntryIdConverter extends IdConverter
{
    protected function idClass(): string
    {
        return PokedexEntryId::class;
    }
}
