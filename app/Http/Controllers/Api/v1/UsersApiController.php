<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Task;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class UsersApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserResource
     */
    public function index()
    {
        return new UserResource(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('ktToken')->accessToken;
        $success['name'] = $user->name;
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return UserResource
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return new UserResource($user);
    }
}
