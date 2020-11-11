<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Task;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TasksApiController extends Controller
{
    public const STATUS = ['finished', 'progress', 'terminated'];

    /**
     * @var TaskRepositoryInterface
     */
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return TaskResource
     */
    public function index()
    {
        return new TaskResource($this->taskRepository->allWithQuery()->paginate(100));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());
        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return TaskResource
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return TaskResource
     * @throws Exception
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return new TaskResource($task);
    }
}
