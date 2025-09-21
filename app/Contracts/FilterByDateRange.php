<?php

declare(strict_types=1);

namespace App\Contracts;

trait FilterByDateRange
{
    /**
     * Filter records within a date range on a custom query builder.
     *
     * @return $this
     */
    public function filterByDateRange(string $columnName, ?string $startDate, ?string $endDate): self
    {
        if ($startDate && $endDate) {
            $this->whereBetween($columnName, [$startDate, $endDate]);
        }

        return $this;
    }
}
