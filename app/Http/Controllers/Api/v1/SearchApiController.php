<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\TaskSearch\TaskSearch;
use App\Http\Controllers\Api\v1\UserSearch\UserSearch;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class SearchApiController extends Controller
{
    /**
     * task filter
     * @param Request $request
     * @return TaskResource
     */
    public function taskFilter(Request $request)
    {
        return TaskSearch::apply($request);
    }


    /**
     * user filter
     * @param Request $request
     * @return UserResource
     */
    public function userFilter(Request $request)
    {
        return UserSearch::apply($request);
    }
}
