<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Persistence\Doctrine\Repository;

use App\Application\Repository\Pokemon\PokemonReadRepository;
use App\Domain\Pokemon\Exception\PokemonNotFoundException;
use App\Domain\Pokemon\Pokemon;
use App\Domain\Pokemon\PokemonId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

/** @extends ServiceEntityRepository<Pokemon> */
final class DoctrinePokemonReadRepository extends ServiceEntityRepository implements PokemonReadRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    public function nextId(): PokemonId
    {
        return PokemonId::fromString(Uuid::uuid4()->toString());
    }

    public function get(PokemonId $id): Pokemon
    {
        $pokemon = $this->find($id);

        if (null === $pokemon) {
            throw PokemonNotFoundException::withId($id);
        }

        return $pokemon;
    }
}
