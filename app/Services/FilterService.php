<?php

namespace App\Services;

use App\Services\ModelFilter\Filter;
use App\Services\ModelFilter\FilterList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class FilterService
{
    public function __construct(
        private FilterList $filterList,
        private Model $model
    ) {
    }

    public function apply(Builder $query, array $filters): void
    {
        $logic = \request()->query('logic', 'and');

        $availableFields = $this->model->getAvailableFilterFields();

        foreach ($filters as $filterField => $fieldFilters) {
            throw_unless(
                in_array($filterField, $availableFields),
                "You can`t use the '{$filterField}' property for filtering"
            );

            $method = ($filterField !== array_key_first($filters) && $logic === 'or') ? 'orWhere' : 'where';
            $query->{$method}(fn(Builder $q) => $this->applyField($q, $filterField, $fieldFilters));
        }
    }

    public function applyField(Builder $q, string $field, array $filters): void
    {
        throw_if(
            str_starts_with(array_key_first($filters), 'or_'),
            'The first element of a property filter must not be prefixed with "or_"'
        );

        foreach ($filters as $filterLogic => $values) {
            if (str_starts_with($filterLogic, 'or_')) {
                $filterLogic = ltrim($filterLogic, 'or_');
                $this->applyFieldFilter($q, $field, $filterLogic, $values, false);
            } else {
                $this->applyFieldFilter($q, $field, $filterLogic, $values);
            }
        }
    }

    public function applyFieldFilter(
        Builder $query,
        string $field,
        string $operator,
        array|string $values,
        bool $and = true
    ): void {
        $filterClass = $this->filterList->get($operator);
        is_array($values) || $values = [$values];

        throw_unless($filterClass, "Undefined filter operator '{$operator}'.");

        /** @var Filter $filter */
        $filter = new $filterClass($query, $field, $values, $and);

        $filter->apply();
    }
}
