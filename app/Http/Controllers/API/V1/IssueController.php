<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\IssueResource;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class IssueController extends Controller
{
    // todo _invoke would have sufficed
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Issue $issue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Issue $issue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Issue $issue)
    {
        //
    }
}
