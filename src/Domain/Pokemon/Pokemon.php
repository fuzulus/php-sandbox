<?php

declare(strict_types=1);

namespace App\Domain\Pokemon;

use App\Domain\Common\CreateTimestampTrait;
use App\Domain\Common\UpdateTimestampTrait;
use App\Domain\Common\VO\Clock;
use App\Domain\Common\VO\NullableClock;
use App\Domain\Pokemon\ViewModel\PokemonViewModel;
use App\Domain\Pokemon\VO\PokemonName;
use App\Domain\Pokemon\VO\PokemonType;

class Pokemon
{
    use CreateTimestampTrait;

    use UpdateTimestampTrait;

    public function __construct(
        private PokemonId $id,
        private PokemonName $name,
        private PokemonType $type1,
        private PokemonType $type2,
        Clock $createdAt,
    ) {
        $this->createdAt = $createdAt;
        $this->updatedAt = NullableClock::createEmpty();
    }

    public function id(): PokemonId
    {
        return $this->id;
    }

    public function name(): PokemonName
    {
        return $this->name;
    }

    public function type1(): PokemonType
    {
        return $this->type1;
    }

    public function type2(): PokemonType
    {
        return $this->type2;
    }

    public function viewModel(): PokemonViewModel
    {
        return new PokemonViewModel(
            (string) $this->id,
            (string) $this->name,
            $this->type1->asStringOrFail(),
            $this->type2->asStringOrNull(),
            $this->createdAt->asInteger(),
            $this->updatedAt->asIntegerOrNull(),
        );
    }
}
