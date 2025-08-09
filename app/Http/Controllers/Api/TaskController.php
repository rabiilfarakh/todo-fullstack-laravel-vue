<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->middleware('auth:api'); 
        $this->taskService = $taskService;
    }

    /**
     * Liste les tâches de l'utilisateur connecté
     */
    public function index()
    {
        $userId = Auth::id();
        $tasks = $this->taskService->listTasks($userId);
        return response()->json($tasks);
    }

    /**
     * Crée une nouvelle tâche
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:pending,done',
        ]);

        $validated['user_id'] = Auth::id();

        $task = $this->taskService->createTask($validated);


        return response()->json($task, 201);
    }

    /**
     * Affiche le détail d'une tâche si elle appartient à l'utilisateur
     */
    public function show($id)
    {
        $userId = Auth::id();
        $task = $this->taskService->findTaskByIdAndUser($id, $userId);

        if (!$task) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        return response()->json($task);
    }

    /**
     * Met à jour une tâche existante
     */
    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $task = $this->taskService->findTaskByIdAndUser($id, $userId);

        if (!$task) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|string|in:pending,done',
        ]);

        $updatedTask = $this->taskService->updateTask($task, $validated);

        return response()->json($updatedTask);
    }

    /**
     * Supprime une tâche
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $task = $this->taskService->findTaskByIdAndUser($id, $userId);

        if (!$task) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        $this->taskService->deleteTask($task);

        return response()->json(['message' => 'Tâche supprimée']);
    }
}
