<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Persistence\Doctrine\Fixtures;

use App\Application\Service\Clock\ClockGenerator;
use App\Domain\Pokedex\PokedexEntry;
use App\Domain\Pokedex\PokedexEntryId;
use App\Domain\Pokedex\VO\PokedexEntryNumber;
use App\Domain\Pokemon\Pokemon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class PokedexEntryFixture extends Fixture implements DependentFixtureInterface
{
    public const IDS = [
        'ed2d206b-41d5-448c-ac70-160de7cd8fb4',
        'ed2d206b-41d5-448c-ac70-160de7cd8fb5',
    ];

    public function __construct(private readonly ClockGenerator $clockGenerator)
    {
    }

    public function getDependencies(): array
    {
        return [
            PokemonFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        /** @var array<int, array{entry: string, name: string, type1: string, type2: string}> $pokemonData */
        $pokemonData = json_decode(file_get_contents(__DIR__ . '/Data/pokemon.json'), true, 512, JSON_THROW_ON_ERROR);

        foreach ($pokemonData as $i => ['entry' => $entry]) {
            if (false === \array_key_exists($i, self::IDS)) {
                continue;
            }

            /** @var Pokemon $pokemon */
            $pokemon = $this->getReference(Pokemon::class . $i);

            $pokedexEntry = new PokedexEntry(
                PokedexEntryId::fromString(self::IDS[$i]),
                new PokedexEntryNumber($entry),
                $pokemon,
                $this->clockGenerator->fromCurrentTime(),
            );

            $manager->persist($pokedexEntry);
        }

        $manager->flush();
    }
}
