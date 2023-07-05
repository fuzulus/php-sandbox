<?php

declare(strict_types=1);

namespace App\Application\CommandHandler\Pokedex;

use App\Application\Command\Pokedex\CreatePokedexEntryCommand;
use App\Application\Repository\Pokedex\PokedexEntryWriteRepository;
use App\Application\Repository\Pokemon\PokemonReadRepository;
use App\Application\Service\Clock\ClockGenerator;
use App\Application\Service\PokedexEntry\PokedexEntryNumberAvailabilityValidator;
use App\Domain\Pokedex\PokedexEntry;

final class CreatePokedexEntryCommandHandler
{
    public function __construct(
        private readonly PokedexEntryNumberAvailabilityValidator $entryNumberAvailabilityValidator,
        private readonly PokemonReadRepository $pokemonReadRepository,
        private readonly ClockGenerator $clockGenerator,
        private readonly PokedexEntryWriteRepository $pokedexEntryWriteRepository,
    ) {
    }

    public function __invoke(CreatePokedexEntryCommand $command): void
    {
        $this->entryNumberAvailabilityValidator->validate($command->number);

        $pokemon = $this->pokemonReadRepository->get($command->pokemonId);

        $pokedexEntry = new PokedexEntry(
            $command->id,
            $command->number,
            $pokemon,
            $this->clockGenerator->fromCurrentTime(),
        );

        $this->pokedexEntryWriteRepository->save($pokedexEntry);
    }
}
