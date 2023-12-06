<?php

namespace App\Services\ModelFilter\Filters;

use App\Services\ModelFilter\Filter;
use Illuminate\Database\Eloquent\Builder;

class NotEqualFilter extends Filter
{
    public function __construct(Builder $query, string $column, string $value)
    {
        parent::__construct($query, $column, $value);
    }

    public function apply(): void
    {
        $this->query->whereNot($this->column, $this->values);
    }
}
