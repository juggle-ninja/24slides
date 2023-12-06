<?php

namespace App\Models\Traits;

use App\Services\FilterService;
use App\Services\ModelFilter\FilterList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

trait Filterable
{
    public function scopeFilter(Builder $query): Builder
    {
        $this->initFilter();

        $filters = request()->query('filters', []);

        /** @var FilterService $filterService */
        $filterService = app(FilterService::class);

        $filterService->apply($query, $filters);

        return $query;
    }

    private function initFilter(): void
    {
        app()->singleton(FilterList::class, fn() => new FilterList());
        app()->when(FilterService::class)->needs(Model::class)->give(fn() => $this);
    }

    public function getAvailableFilterFields(): array
    {
        //todo add logic for relation
        return $this->filterFields ?? Schema::getColumns($this->getTable());
    }
}
