<?php

declare(strict_types=1);

namespace App\Builders;

use App\Contracts\FilterByDateRange;
use Illuminate\Database\Eloquent\Builder;

final class DailyUsageBuilder extends Builder
{
    use FilterByDateRange;
}
