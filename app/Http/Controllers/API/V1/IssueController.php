<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\IssueResource;
use App\Models\Issue;
use App\Services\ModelFilter\FilterList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class IssueController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        //todo validation,  IssueResource::collection -> IssueCollection

        return IssueResource::collection(
            Cache::tags(['issues'])
                ->remember(
                    GlobalHelper::getCacheKey(),
                    60 * 60,
                    fn() => Issue::query()
                        ->filter()
                        ->paginate()
                )
        );
    }

    /**
     * basic info only
     *
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function filters(): JsonResponse
    {
        $availableFiltersInfo = app(FilterList::class)->getFiltersInfo();

        return response()->json([
                'available_query_params' => [
                    'filters' => collect(app()->make(Issue::class)->getAvailableFilterFields())
                        ->reduce(function ($result, $filterField) use ($availableFiltersInfo) {
                            foreach ($availableFiltersInfo as $prefix => $description) {
                                $result[$filterField][] = "{$prefix}:{$filterField}";
                            }
                            return $result;
                        }, []),

                    'logic' => ['and', 'or']
                ],
                'info' => [
                    'filters' => $availableFiltersInfo,
                ]
            ]
        );
    }
}
