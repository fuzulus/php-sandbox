<?php

declare(strict_types=1);

namespace App\Tests\Integration\Application\CommandHandler\Pokedex;

use App\Application\Command\Pokedex\CreatePokedexEntryCommand;
use App\Application\CommandHandler\Pokedex\CreatePokedexEntryCommandHandler;
use App\Application\Repository\Pokedex\PokedexEntryReadRepository;
use App\Domain\Pokedex\Exception\PokedexEntryAlreadyExistsForPokemonException;
use App\Domain\Pokedex\Exception\PokedexEntryNumberTakenException;
use App\Domain\Pokedex\VO\PokedexEntryNumber;
use App\Domain\Pokemon\PokemonId;
use App\Infrastructure\Driven\Persistence\Doctrine\Fixtures\PokemonFixture;
use App\Tests\Integration\IntegrationTestCase;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @coversDefaultClass \App\Application\CommandHandler\Pokedex\CreatePokedexEntryCommandHandler
 *
 * @small
 */
final class CreatePokedexEntryCommandHandlerTest extends IntegrationTestCase
{
    private static PokedexEntryReadRepository $pokedexEntryReadRepository;

    private static EntityManagerInterface $entityManager;

    private static CreatePokedexEntryCommandHandler $commandHandler;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        /** @var PokedexEntryReadRepository $pokedexEntryReadRepository */
        $pokedexEntryReadRepository = self::getContainer()->get(PokedexEntryReadRepository::class);
        self::$pokedexEntryReadRepository = $pokedexEntryReadRepository;

        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);
        self::$entityManager = $entityManager;

        /** @var CreatePokedexEntryCommandHandler $commandHandler */
        $commandHandler = self::getContainer()->get(CreatePokedexEntryCommandHandler::class);
        self::$commandHandler = $commandHandler;
    }

    public function testCommandWillCreatePokedexEntry(): void
    {
        $command = new CreatePokedexEntryCommand(
            self::$pokedexEntryReadRepository->nextId(),
            new PokedexEntryNumber('#0003'),
            PokemonId::fromString(PokemonFixture::NO_POKEDEX_ENTRY_ID),
        );

        self::$commandHandler->__invoke($command);

        $pokedexEntry = self::$pokedexEntryReadRepository->get($command->id);

        self::$entityManager->clear();

        static::assertSame((string) $command->id, (string) $pokedexEntry->id());
        static::assertSame((string) $command->number, (string) $pokedexEntry->number());
        static::assertSame((string) $command->pokemonId, (string) $pokedexEntry->pokemon()->id());
    }

    public function testCommandWillThrowExceptionIfPokedexEntryNumberIsTaken(): void
    {
        $command = new CreatePokedexEntryCommand(
            self::$pokedexEntryReadRepository->nextId(),
            new PokedexEntryNumber('#0002'),
            PokemonId::fromString(PokemonFixture::NO_POKEDEX_ENTRY_ID),
        );

        $this->expectException(PokedexEntryNumberTakenException::class);
        self::$commandHandler->__invoke($command);
    }

    public function testCommandWillThrowExceptionIfPokedexEntryAlreadyExistsForPokemon(): void
    {
        $command = new CreatePokedexEntryCommand(
            self::$pokedexEntryReadRepository->nextId(),
            new PokedexEntryNumber('#0003'),
            PokemonId::fromString(PokemonFixture::IDS[0]),
        );

        $this->expectException(PokedexEntryAlreadyExistsForPokemonException::class);
        self::$commandHandler->__invoke($command);
    }
}
