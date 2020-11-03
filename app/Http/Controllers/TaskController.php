<?php

namespace App\Http\Controllers;

use App\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    const STATUS = ['finished', 'progress', 'terminated'];

    /* @var \Illuminate\Http\Request $request */
    protected $request;
    /* @var \Illuminate\Routing\ResponseFactory $response */
    protected $response;

    /**
     * MobileApiController constructor.
     */
    public function __construct()
    {
        $this->response = response();
        $this->middleware(function ($request, $next) {
            $this->request = $request;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return Task[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws Exception
     */
    public function store()
    {
        $validate = Validator::make(request()->all(), [
            'title'  => 'required',
            'body'   => 'required',
            'status' => 'required|in:' . implode(',', self::STATUS),
        ]);
        $this->checkValidationFails($validate);
        $task = Task::create(request()->all());
        $task->save();
        $this->sendResponse([
            'status'  => 'success',
            'message' => 'Задача создана',
            'task_id' => $task->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return void
     * @throws Exception
     */
    public function show($id)
    {
        $issueTask = Task::find($id);
        if (!$issueTask) {
            $this->sendResponse(
                [
                    'status'  => 'error',
                    'message' => 'Задача не найдена',
                ],
                404
            );
        } else {
            return $issueTask;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return void
     * @throws Exception
     */
    public function update($id)
    {
        $verifiedArray = array_merge(['id' => $id], $this->request->all());
        $valid = Validator::make($verifiedArray, [
            'id'     => 'required|exists:tasks,id',
            'title'  => 'required',
            'body'   => 'required',
            'status' => 'required|in:' . implode(',', self::STATUS),
        ], [
            'id.required' => 'ID обязательно',
            'id.exists'   => "Задача с ID: $id не существует",
        ]);
        $this->checkValidationFails($valid);
        $updatedModel = Task::find($id);
        if ($updatedModel) {
            $updatedModel->title = $this->request->title;
            $updatedModel->body = $this->request->body;
            $updatedModel->user_id = $this->request->user_id ?? null;
            $updatedModel->save();
            $this->sendResponse(
                [
                    'status'  => 'success',
                    'message' => 'Задача обновлена',
                    'task_id' => $updatedModel->id
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return void
     * @throws Exception
     */
    public function destroy($id)
    {
        $valid = Validator::make(['id' => $id], [
            'id' => 'required|exists:tasks,id',
        ], [
            'id.required' => 'ID обязательно',
            'id.exists'   => "Задача с ID: $id не существует",
        ]);
        $this->checkValidationFails($valid);
        $post = Task::find($id);
        $post->delete();
        //softDelete ?
        $this->sendResponse([
            'status'  => 'success',
            'message' => 'Задача удалена',
            'task_id' => $post->id
        ]);
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
