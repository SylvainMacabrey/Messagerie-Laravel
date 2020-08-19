<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessage;
use App\Repository\ConversationRepository;
use App\User;
use Illuminate\Http\Request;

class ConversationController extends Controller
{

    private $conversationRepository;

    public function __construct(ConversationRepository $conversationRepository) {
        $this->conversationRepository = $conversationRepository;
    }

    public function index(Request $request) {
        return [
            'conversations' => $this->conversationRepository->getConverastions($request->user()->id)
        ];
    }

    public function show(Request $request, User $user) {
        $messages = $this->conversationRepository->getMessagesFor($request->user()->id, $user->id)->get();
        return [
            'messages' => $messages->reverse()
        ];
    }

    public function store(StoreMessage $request, User $user) {
        $message = $this->conversationRepository->createMessage($request->get('content'), $request->user()->id, $user->id);
        return [
            'message' => $message
        ];
    }

}
