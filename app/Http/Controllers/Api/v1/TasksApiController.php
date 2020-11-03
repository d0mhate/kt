<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Task;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class TasksApiController extends Controller
{
    const STATUS = ['finished', 'progress', 'terminated'];

    /**
     * Display a listing of the resource.
     *
     * @return TaskResource
     */
    public function index()
    {
        return new TaskResource(Task::all());
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

    /**
     * Проверка валидации
     * При неудавшейся валидации выбрасывает исключение
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws Exception
     */
    protected function checkValidationFails(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        if ($validator->fails()) {
            $errors = implode("\n ", $validator->errors()->all());
            $this->sendResponse($validator->errors()->all(), 404);
            throw new Exception($errors, 400);
        }
    }

    /**
     * Отпавка ответа
     * @param array | Collection $data
     * @param int $code
     * @return null
     */
    protected function sendResponse($data, int $code = 200)
    {
        $this->response->json($data, $code, ['Content-Type' => 'application/json'])->send();
        return null;
    }
}
