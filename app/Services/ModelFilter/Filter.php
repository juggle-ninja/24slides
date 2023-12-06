<?php

namespace App\Services\ModelFilterService;


use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(
        protected Builder $query,
        protected string $column,
        protected array $values
    ) {}

    abstract function apply(): Builder;

    public static function operator(): string
    {
        return static::$operator;
    }

}
