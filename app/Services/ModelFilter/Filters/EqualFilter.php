<?php

namespace App\Services\ModelFilter\Filters;

use App\Services\ModelFilter\Filter;
use Illuminate\Database\Eloquent\Builder;

class EqualFilter extends Filter
{
    protected static string $operator = 'equal';

    function apply(): Builder
    {
        foreach ($this->values as $value) {
            $this->query->where($this->column, $value);
        }
        return $this->query;
    }
}
