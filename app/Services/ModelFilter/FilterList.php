<?php

namespace App\Services\ModelFilter;

use App\Services\ModelFilter\Filters\ContainsFilter;
use App\Services\ModelFilter\Filters\InFilter;
use App\Services\ModelFilter\Filters\EqualsFilter;
use App\Services\ModelFilter\Filters\NotEqualFilter;
use App\Services\ModelFilter\Filters\NotContainFilter;
use App\Services\ModelFilter\Filters\NotInFilter;

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
            'is' => EqualsFilter::class,
            '!is' => NotEqualFilter::class,
            'in' => InFilter::class,
            '!in' => NotInFilter::class,
            'contain' => ContainsFilter::class,
            '!contain' => NotContainFilter::class
        ];
    }

    public function get(string $operator): ?string
    {
        return @$this->filters[$operator];
    }

    public function getFiltersInfo(): array
    {
        return collect($this->filters)->map(
            fn($class) => rtrim((new \ReflectionClass($class))->getShortName(), 'Filter')
        )
            ->toArray();
    }
}
