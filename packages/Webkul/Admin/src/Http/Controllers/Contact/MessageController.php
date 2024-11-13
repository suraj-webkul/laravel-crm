<?php

namespace Webkul\Admin\Http\Controllers\Contact;

use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Contact\Repositories\MessageRepository;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected MessageRepository $messageRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->messageRepository->with('user')->get();
    }

    public function store()
    {
        $message = $this->messageRepository->create([
            'sender_id' => auth()->user()->id,
            'content' => request()->message,
        ]);

        return response()->json([
            'data' => $message
        ]);
    }
}
