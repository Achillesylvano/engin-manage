<?php

declare(strict_types=1);

namespace App\Actions\Engins;

use App\Models\Engin;

final class CreateEnginAction
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): Engin
    {
        return \App\Models\Engin::query()->create($data);
    }
}
