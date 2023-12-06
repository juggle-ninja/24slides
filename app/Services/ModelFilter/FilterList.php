<?php

namespace App\Services\ModelFilterService;

use App\Services\ModelFilter\Filters\EqualFilter;
use App\Services\ModelFilter\Filters\OrFilter;

class FilterList
{
    public array $filters = [];

    public function __construct()
    {
        $this->loadFilters();
    }

    private function loadFilters(): void
    {
        $this->filters = [
            EqualFilter::class,
            OrFilter::class
        ];
    }
}
