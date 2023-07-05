<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Persistence\Doctrine\Repository;

use App\Application\Repository\Pokedex\PokedexEntryReadRepository;
use App\Domain\Pokedex\Exception\PokedexEntryNotFoundException;
use App\Domain\Pokedex\PokedexEntry;
use App\Domain\Pokedex\PokedexEntryId;
use App\Domain\Pokedex\VO\PokedexEntryNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

/** @extends ServiceEntityRepository<PokedexEntry> */
final class DoctrinePokedexEntryReadRepository extends ServiceEntityRepository implements PokedexEntryReadRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokedexEntry::class);
    }

    public function nextId(): PokedexEntryId
    {
        return PokedexEntryId::fromString(Uuid::uuid4()->toString());
    }

    public function get(PokedexEntryId $id): PokedexEntry
    {
        $pokedexEntry = $this->find($id);

        if (null === $pokedexEntry) {
            throw PokedexEntryNotFoundException::withId($id);
        }

        return $pokedexEntry;
    }

    public function findByEntryNumber(PokedexEntryNumber $number): ?PokedexEntry
    {
        return $this->findOneBy(['number.number' => (string) $number]);
    }
}
