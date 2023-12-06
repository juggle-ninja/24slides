<?php

namespace App\Services;

use App\Models\Traits\Filterable;
use App\Services\ModelFilter\FilterList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\NoTraitException;


class ModelFilterService
{
    protected string $requestOperatorKey = 'operator';

    protected string $requestFilterKey = 'filter';
    protected string $requestFilterLogicKey = 'filter_logic';

    protected array $filters = [];

    protected string $operator = '';

    public function __construct(
        private FilterList $filterList,
        private Model $model
    ) {
        dd($this->model, $this->filterList);

//        $this->model = $this->query->getModel();
//
//        throw_if(
//            !in_array(Filterable::class, (new \ReflectionClass($this->model))->getTraitNames()),
//            new NoTraitException()
//        );
//
//        $this
//            ->setQueryOperator()
//            ->setModelFilters();
    }

    public function applyFilters(Builder $query, Request $request): Builder
    {
        foreach ($this->filters as $key => $fieldData) {
            $method = ($this->operator === 'or' && $key === 0) ? 'orWhere' : 'where';

            match ($fieldData['logic']) {
                'is' => $query->{$method}($fieldData['field'], '=', $fieldData['value']),
                'is_not' => $query->{$method}($fieldData['field'], '!=', $fieldData['value']),
                'in' => $query->{$method}($fieldData['field'], 'In', $fieldData['value']),
                'not_in' => $query->{$method}($fieldData['field'], 'NotIn', $fieldData['value']),
                'contains' => $query->{$method}($fieldData['field'], 'like', "%{$fieldData['value']}%"),
                'not_contains' => $query->{$method}($fieldData['field'], 'not like', "%{$fieldData['value']}%"),
            };
        }

        return $query;
    }

    protected function setQueryOperator(): self
    {
        match (strtoupper($this->request->get($this->requestOperatorKey))) {
            'OR' => $this->operator = 'or',
            default => $this->operator = 'and'
        };

        return $this;
    }

    protected function setModelFilters(): self
    {
        $requestFilters = (array)$this->request->get($this->requestFilterKey);
        $requestFilterLogic = (array)$this->request->get($this->requestFilterLogicKey);

        if (count($requestFilters)) {
            foreach ($this->model->getFilterFields() as $type => $fields) {
                foreach ($fields as $field) {
                    if (!isset($requestFilters[$field])) {
                        continue;
                    }
                    $logic = @$requestFilterLogic[$field];

                    $logicList = $this->model->getFilterTypeLogic($type);
                    $this->filters[] = [
                        'field' => $field,
                        'value' => $requestFilters[$field],
                        'logic' => ($logic && in_array($logic, $logicList)) ? $logic : reset($logicList)
                    ];
                }
            }
        }

        return $this;
    }


    protected function getWhereOperator(){

    }


    public function apply(Builder $query, string $field, array|string $values): void
    {
        $this->filter($query, $field, $values);
    }

    private function filter(Builder $query, string $field, array|string $values):void
    {
        is_array($values) || $values = [$values];

        dd($this->filterList);
    }
}
