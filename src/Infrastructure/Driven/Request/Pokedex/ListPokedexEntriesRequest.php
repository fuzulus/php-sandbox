<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Request\Pokedex;

use App\Application\Query\PokedexEntry\PokedexEntryQuery;
use Undabot\JsonApi\Definition\Model\Request\GetResourceCollectionRequestInterface;

final class ListPokedexEntriesRequest
{
    private const FILTER_NUMBER = 'number';

    public function __construct(
        private GetResourceCollectionRequestInterface $request,
    ) {
        $request->allowIncluded([]);
        $request->allowFilters([
            self::FILTER_NUMBER,
        ]);
        $request->allowSorting([]);
    }

    public function hasIncludes(): bool
    {
        return false === empty($this->request->getIncludes());
    }

    public function buildQuery(): PokedexEntryQuery
    {
        $pagination = $this->request->getPagination();
        $filterSet = $this->request->getFilterSet();

        return new PokedexEntryQuery(
            $pagination?->getOffset(),
            $pagination?->getSize(),
            $filterSet?->getFilterValue(self::FILTER_NUMBER),
        );
    }
}
