<?php


namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService
{
    protected $taskRepo;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepo = $taskRepository;
    }

    public function listTasks($userId)
    {
        return $this->taskRepo->getByUserId($userId);
    }

    public function createTask(array $data)
    {

        $task = $this->taskRepo->create($data);
        return $task;
    }


}
