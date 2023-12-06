<?php

namespace App\Models\Traits;

use App\Services\ModelFilterService;
use App\Services\ModelFilter\FilterList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

trait Filterable
{
    public function scopeFilter(Builder $query, ?array $filters = null): Builder
    {
        $this->initFilter();

        if (is_null($filters)) {
            $filters = request()->query('filters', []);
        }

        app(ModelFilterService::class)->apply($query, $filters);

        return $query;
    }

    private function initFilter(): void
    {
        app()->singleton(FilterList::class, fn() => new FilterList());
        app()->when(ModelFilterService::class)->needs(Model::class)->give(fn() => $this);
    }

    public function getAvailableFilterFields(): array
    {
        //todo add ability to provide custom relation filters
        return Schema::getColumns($this->getTable());
    }
}
