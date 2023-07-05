<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Persistence\Doctrine\Fixtures;

use App\Application\Service\Clock\ClockGenerator;
use App\Domain\Pokemon\Enum\PokemonTypeEnum;
use App\Domain\Pokemon\Pokemon;
use App\Domain\Pokemon\PokemonId;
use App\Domain\Pokemon\VO\PokemonName;
use App\Domain\Pokemon\VO\PokemonType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class PokemonFixture extends Fixture
{
    public const NO_POKEDEX_ENTRY_ID = 'b74dca84-d066-49c4-b91a-72cecdee68d3';

    public const IDS = [
        'b74dca84-d066-49c4-b91a-72cecdee68d1',
        'b74dca84-d066-49c4-b91a-72cecdee68d2',
        self::NO_POKEDEX_ENTRY_ID,
    ];

    public function __construct(private readonly ClockGenerator $clockGenerator)
    {
    }

    public function load(ObjectManager $manager): void
    {
        /** @var array<int, array{entry: string, name: string, type1: string, type2: string}> $pokemonData */
        $pokemonData = json_decode(file_get_contents(__DIR__ . '/Data/pokemon.json'), true, 512, JSON_THROW_ON_ERROR);

        foreach ($pokemonData as $i => $pokemon) {
            $entity = new Pokemon(
                PokemonId::fromString(self::IDS[$i]),
                new PokemonName($pokemon['name']),
                PokemonType::createFromEnum(PokemonTypeEnum::from($pokemon['type1'])),
                PokemonType::createFromEnum(PokemonTypeEnum::from($pokemon['type2'])),
                $this->clockGenerator->fromCurrentTime(),
            );

            $manager->persist($entity);

            $this->setReference(Pokemon::class . $i, $entity);
        }

        $manager->flush();
    }
}
