<?php

namespace App\Services\ModelFilter\Filters;

use App\Services\ModelFilter\Filter;
use Illuminate\Database\Eloquent\Builder;

class EqualsFilter extends Filter
{
    public function __construct(Builder $query, string $column, string $value)
    {
            parent::__construct($query, $column, $value);
    }

    public function apply(): void
    {
        $this->query->where($this->column, $this->values);
    }
}
