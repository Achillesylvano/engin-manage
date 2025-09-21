<?php

declare(strict_types=1);

namespace App\Actions\Engins;

use App\Models\Engin;

final class UpdateEnginAction
{
    public function execute(Engin $engin, array $data): bool
    {
        return $engin->update($data);
    }
}
