<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Response\Pokedex;

use Undabot\SymfonyJsonApi\Model\Collection\ObjectCollection;

final class ListPokedexEntriesResponse
{
    public function __construct(
        private readonly ObjectCollection $pokedexEntries,
    ) {
    }

    public function resources(): ObjectCollection
    {
        return $this->pokedexEntries;
    }
}
