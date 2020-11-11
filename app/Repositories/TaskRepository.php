<?php


namespace App\Repositories;


use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function allWithQuery()
    {
        return Task::query();
    }

    public function all()
    {
        return Task::all();
    }

    public function getByTask(Task $task)
    {
        return Task::where('id', $task->id)->get();
    }
}