<?php

namespace Webkul\Chatter\Http\Controllers;

use Illuminate\Http\Client\Request;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\User\Repositories\UserRepository;
use Webkul\Chatter\Repositories\TaskRepository;

class TaskController extends Controller
{
    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct(
        protected TaskRepository $taskRepository,
        protected UserRepository $userRepository
    )
    {
    }

    public function store(Request $request)
    {
        $task = $this->taskRepository->create($request->only('title', 'description'));

        return response()->json($task, 201);
    }

    public function getFollowers($taskId)
    {
        $task = $this->taskRepository->find($taskId);

        $followers = $task->followers;

        return response()->json($followers);
    }

    public function addFollower($taskId, $userId)
    {
        $task = $this->taskRepository->find($taskId);

        $user = $this->userRepository->find($userId);

        $task->followers()->attach($user->id);

        return response()->json(['message' => 'Follower added successfully.']);
    }

    public function removeFollower($taskId, $userId)
    {
        $task = $this->taskRepository->find($taskId);

        $user = $this->userRepository->find($userId);

        $task->followers()->detach($user->id);

        return response()->json(['message' => 'Follower removed successfully.']);
    }

    public function showMessages($taskId)
    {
        $task = $this->taskRepository->find($taskId);

        $messages = $task->messages()->with('user')->latest()->get();
        
        return response()->json($messages);
    }

    public function postMessage($taskId)
    {
        $task = $this->taskRepository->find($taskId);

        $message = $task->messages()->create([
            'user_id' => auth()->user()->id,
            'content' => request()->content,
        ]);

        return response()->json($message, 201);
    }
}
