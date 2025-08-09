<?php


namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function listTasks($userId)
    {
        return Task::where('user_id', $userId)->get();
    }

    public function createTask(array $data)
    {
        return Task::create($data);
    }

    public function findTaskByIdAndUser($id, $userId)
    {
        return Task::where('id', $id)->where('user_id', $userId)->first();
    }

    public function updateTask(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
    }
}
