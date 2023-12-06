<?php

namespace App\Services\ModelFilter;

use App\Services\ModelFilter\Filters\ContainsFilter;
use App\Services\ModelFilter\Filters\InFilter;
use App\Services\ModelFilter\Filters\IsFilter;
use App\Services\ModelFilter\Filters\IsNotFilter;
use App\Services\ModelFilter\Filters\NotContainFilter;

class FilterList
{
    public array $filters = [];

    public function __construct()
    {
        $this->initFilters();
    }

    private function initFilters(): void
    {
        $this->filters = [
            'is' => IsFilter::class, // column = value
            'in_not' =>  IsNotFilter::class, //column != value
            'in' => InFilter::class, //column in (values)
            'contains' => ContainsFilter::class, //column like %value%,
            'not_contain' => NotContainFilter::class //column not like %value%
        ];
    }

    public function get(string $operator): ?string
    {
        return $this->filters[$operator];
    }
}
