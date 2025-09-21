<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Fluent;

final readonly class EntityRepository
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    /**
     * Retourne les entités filtrées selon les Fluent filters
     */
    public function getFiltered(Fluent $filters): Collection
    {
        if (method_exists($this->query, 'filterByDate')) {
            $this->query = $this->query->filterByDate($filters);
        }

        return $this->query->get();
    }
}
