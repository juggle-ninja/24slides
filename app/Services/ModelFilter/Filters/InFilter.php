<?php

namespace App\Services\ModelFilter\Filters;

use App\Services\ModelFilter\Filter;

class InFilter extends Filter
{
    public function apply(): void
    {
        $method = (!$this->and) ? 'orWhereIn' : 'whereIn';
        $this->query->$method($this->column, $this->values);
    }
}
