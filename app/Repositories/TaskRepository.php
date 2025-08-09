<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function getByUserId($userId)
    {
        return Task::where('user_id', $userId)->get();
    }

    public function findByIdAndUser($id, $userId)
    {
        return Task::where('id', $id)->where('user_id', $userId)->first();
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task)
    {
        $task->delete();
    }
}
