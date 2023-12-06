<?php

namespace App\Services\ModelFilter\Filters;

use App\Services\ModelFilter\Filter;

class NotInFilter extends Filter
{
    public function apply(): void
    {
        $values = is_array($this->values) ?: explode(',', (string) $this->values);
        $this->query->whereNotIn($this->column, $values);
    }
}
