<?php

declare(strict_types=1);

namespace App\Actions\Engins;

use App\Models\Engin;

final class DeleteEnginAction
{
    public function execute(Engin $engin): bool
    {
        return (bool) $engin->delete();
    }
}
