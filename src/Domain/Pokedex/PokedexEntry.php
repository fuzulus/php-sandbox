<?php

declare(strict_types=1);

namespace App\Domain\Pokedex;

use App\Domain\Common\CreateTimestampTrait;
use App\Domain\Common\UpdateTimestampTrait;
use App\Domain\Common\VO\Clock;
use App\Domain\Common\VO\NullableClock;
use App\Domain\Pokedex\ViewModel\PokedexEntryViewModel;
use App\Domain\Pokedex\VO\PokedexEntryNumber;
use App\Domain\Pokemon\Pokemon;

class PokedexEntry
{
    use CreateTimestampTrait;

    use UpdateTimestampTrait;

    public function __construct(
        private readonly PokedexEntryId $id,
        private PokedexEntryNumber $number,
        private Pokemon $pokemon,
        Clock $createdAt,
    ) {
        $this->createdAt = $createdAt;
        $this->updatedAt = NullableClock::createEmpty();
    }

    public function id(): PokedexEntryId
    {
        return $this->id;
    }

    public function number(): PokedexEntryNumber
    {
        return $this->number;
    }

    public function pokemon(): Pokemon
    {
        return $this->pokemon;
    }

    public function update(
        PokedexEntryNumber $number,
        NullableClock $updatedAt,
    ): void {
        $this->number = $number;
        $this->updatedAt = $updatedAt;
    }

    public function viewModel(): PokedexEntryViewModel
    {
        return new PokedexEntryViewModel(
            (string) $this->id,
            (string) $this->number,
            (string) $this->pokemon->id(),
            $this->createdAt->asInteger(),
            $this->updatedAt->asIntegerOrNull(),
        );
    }
}
