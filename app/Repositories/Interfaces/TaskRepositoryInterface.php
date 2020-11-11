<?php


namespace App\Repositories\Interfaces;

use App\Task;

interface TaskRepositoryInterface
{
    public function all();

    public function getByTask(Task $task);

    public function allWithQuery();
}