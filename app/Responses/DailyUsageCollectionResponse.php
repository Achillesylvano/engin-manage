<?php

declare(strict_types=1);

namespace App\Responses;

use App\Http\Resources\DailyUsageCollection;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class DailyUsageCollectionResponse implements Responsable
{
    public function __construct(
        private readonly Collection|LengthAwarePaginator $collection,
        private readonly int $status = 200
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json(
            DailyUsageCollection::make($this->collection)
                ->response()
                ->getData(),
            $this->status
        );
    }
}
