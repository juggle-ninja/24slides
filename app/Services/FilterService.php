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
        $queryLogic = \request()->query('logic', 'and');

        $availableFields = $this->model->getAvailableFilterFields();

        foreach ($filters as $key => $value) {
            if (str_contains($key, ':')) {
                [$logic, $filterField] = explode(':', $key);
            } else {
                [$logic, $filterField] = ['is', $key];
            }
            throw_unless(
                in_array($filterField, $availableFields),
                "'{$filterField}' property is not available for filtering"
            );

            $method = ($filterField !== array_key_first($filters) && $queryLogic === 'or') ? 'orWhere' : 'where';
            $query->{$method}(fn(Builder $q) => $this->applyFieldFilter($q, $filterField, $value, $logic));
        }
    }

    public function applyFieldFilter(Builder $q, string $field, array|string $values, string $logic): void
    {
        $filterClass = $this->filterList->get($logic);

        throw_unless($filterClass, "Undefined filter logic '{$logic}'.");

        /** @var Filter $filter */
        $filter = new $filterClass($q, $field, $values);
        $filter->apply();

    }
}
