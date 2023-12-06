<?php

namespace App\Services\ModelFilter\Filters;

use App\Services\ModelFilter\Filter;
use Illuminate\Database\Eloquent\Builder;

class IsFilter extends Filter
{
    public function apply(): void
    {
        foreach ($this->values as $key => $value) {
            $method = (!$this->and && array_key_first($this->values) !== $key) ? 'orWhere' : 'where';
            $this->query->{$method}($this->column, $value);
        }
    }
}
