<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\QueryHandler\Pokedex;

use App\Application\Query\PokedexEntry\PokedexEntryQuery;
use App\Domain\Pokedex\PokedexEntry;
use App\Domain\Pokedex\ViewModel\PokedexEntryListViewModel;
use App\Infrastructure\Driven\QueryHandler\DoctrineQueryHandler;
use Undabot\SymfonyJsonApi\Model\Collection\ObjectCollection;

final class PokedexEntryQueryHandler extends DoctrineQueryHandler
{
    public function __invoke(PokedexEntryQuery $query): ObjectCollection
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select(sprintf('
                new %s(
                    pe.id,
                    pe.number.number,
                    p.name.name,
                    p.type1.type,
                    p.type2.type,
                    pe.createdAt.timestamp,
                    pe.updatedAt.timestamp
                )
            ', PokedexEntryListViewModel::class))
            ->from(PokedexEntry::class, 'pe')
            ->innerJoin('pe.pokemon', 'p');

        if (null !== $query->number) {
            $qb->andWhere('pe.number.number = :entryNumber')
                ->setParameter('entryNumber', $query->number);
        }

        return $this->makePaginatedResultsIfNeeded($qb, $query);
    }
}
