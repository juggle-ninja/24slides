<?php

namespace App\Services\ModelFilter;


use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(
        protected Builder $query,
        protected string $column,
        protected array|string $values
    ) {
    }

    abstract public function apply(): void;
}
