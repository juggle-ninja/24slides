<?php

namespace App\Services\ModelFilter\Filters;

use App\Services\ModelFilter\Filter;
use Illuminate\Database\Eloquent\Builder;

class OrFilter extends Filter
{
    protected static string $operator = 'or';

    function apply(): Builder
    {
        foreach ($this->values as $value) {
            $this->query->where($this->column, $value);
        }
        return $this->query;
    }
}
