<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\QueryHandler;

use App\Application\Query\PaginatedQuery;
use App\Application\QueryHandler\PaginatedQueryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Undabot\SymfonyJsonApi\Model\Collection\ArrayCollection;
use Undabot\SymfonyJsonApi\Model\Collection\ObjectCollection;
use Undabot\SymfonyJsonApi\Service\Pagination\Paginator;

abstract class DoctrineQueryHandler implements PaginatedQueryHandler
{
    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }

    public function makePaginatedResultsIfNeeded(QueryBuilder $queryBuilder, PaginatedQuery $query): ObjectCollection
    {
        if (null !== $query->offset && null !== $query->size) {
            return (new Paginator())
                ->createPaginatedCollection(
                    $queryBuilder,
                    $query->offset,
                    $query->size
                );
        }

        $result = $queryBuilder->getQuery()->getResult();

        if (\is_array($result)) {
            return new ArrayCollection($result);
        }

        throw new \LogicException(
            sprintf(
                'Expected array, got %s.',
                get_debug_type($result),
            ),
        );
    }
}
