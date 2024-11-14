<?php

namespace Webkul\Chatter\Http\Controllers;

use Illuminate\Http\Client\Request;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Chatter\Repositories\MessageRepository;
use Webkul\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Webkul\Chatter\Mail\NewMessage;

class MessageController extends Controller
{
    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct(
        protected MessageRepository $messageRepository,
        protected UserRepository $userRepository
    )
    {
    }

    public function index(Request $request)
    {
        $userId = auth()->id();

        $messages = $this->messageRepository->where(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
        })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($messages);
    }

    public function store()
    {
        $validated = request()->validate([
            'content' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
            'send_email' => 'boolean'
        ]);

        $message = $this->messageRepository->create([
            'content'     => $validated['content'],
            'sender_id'   => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'send_email'  => $validated['send_email'] ?? true
        ]);

        if ($message->send_email) {
            $receiver = $this->userRepository->find($validated['receiver_id']);

            Mail::to($receiver->email)->queue(new NewMessage($message));
        }

        return response()->json($message->load(['sender', 'receiver']));
    }


    public function getUserMessages($id)
    {
        $messages = $this->messageRepository->where(function($query) use ($id) {
                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $id);
            })->orWhere(function($query) use ($id) {
                $query->where('sender_id', $id)
                    ->where('receiver_id', auth()->id());
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($messages);
    }
}
