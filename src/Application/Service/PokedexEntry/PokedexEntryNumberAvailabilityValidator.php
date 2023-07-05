<?php

declare(strict_types=1);

namespace App\Application\Service\PokedexEntry;

use App\Application\Repository\Pokedex\PokedexEntryReadRepository;
use App\Domain\Pokedex\Exception\PokedexEntryNumberTakenException;
use App\Domain\Pokedex\PokedexEntry;
use App\Domain\Pokedex\VO\PokedexEntryNumber;

final class PokedexEntryNumberAvailabilityValidator
{
    public function __construct(private readonly PokedexEntryReadRepository $pokedexEntryReadRepository)
    {
    }

    /** @throws PokedexEntryNumberTakenException */
    public function validate(PokedexEntryNumber $entryNumber): void
    {
        if (null !== $this->pokedexEntryReadRepository->findByEntryNumber($entryNumber)) {
            throw new PokedexEntryNumberTakenException($entryNumber);
        }
    }

    public function validateForExisting(PokedexEntryNumber $entryNumber, PokedexEntry $pokedexEntry): void
    {
        $existingPokedexEntry = $this->pokedexEntryReadRepository->findByEntryNumber($entryNumber);

        if (
            null !== $existingPokedexEntry
            && ((string) $pokedexEntry->id() !== (string) $existingPokedexEntry->id())
        ) {
            throw new PokedexEntryNumberTakenException($entryNumber);
        }
    }
}
