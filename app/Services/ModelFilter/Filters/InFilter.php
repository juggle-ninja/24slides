<?php

namespace App\Services\ModelFilter\Filters;

use App\Services\ModelFilter\Filter;

class InFilter extends Filter
{
    public function apply(): void
    {
        $values = is_array($this->values) ? $this->values : explode(',', (string)$this->values);
        $this->query->whereIn($this->column, $values);
    }
}
