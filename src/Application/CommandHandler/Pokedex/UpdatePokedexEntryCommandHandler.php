<?php

declare(strict_types=1);

namespace App\Application\CommandHandler\Pokedex;

use App\Application\Command\Pokedex\UpdatePokedexEntryCommand;
use App\Application\Repository\Pokedex\PokedexEntryReadRepository;
use App\Application\Repository\Pokedex\PokedexEntryWriteRepository;
use App\Application\Service\Clock\ClockGenerator;
use App\Application\Service\PokedexEntry\PokedexEntryNumberAvailabilityValidator;
use App\Domain\Common\VO\NullableClock;

final class UpdatePokedexEntryCommandHandler
{
    public function __construct(
        private readonly PokedexEntryReadRepository $pokedexEntryReadRepository,
        private readonly PokedexEntryNumberAvailabilityValidator $pokedexEntryNumberAvailabilityValidator,
        private readonly ClockGenerator $clockGenerator,
        private readonly PokedexEntryWriteRepository $pokedexEntryWriteRepository,
    ) {
    }

    public function __invoke(UpdatePokedexEntryCommand $command): void
    {
        $pokedexEntry = $this->pokedexEntryReadRepository->get($command->id);

        $this->pokedexEntryNumberAvailabilityValidator->validateForExisting($command->number, $pokedexEntry);

        $pokedexEntry->update(
            $command->number,
            NullableClock::fromClock($this->clockGenerator->fromCurrentTime()),
        );

        $this->pokedexEntryWriteRepository->save($pokedexEntry);
    }
}
