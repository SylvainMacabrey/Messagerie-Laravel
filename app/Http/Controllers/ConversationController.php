<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessage;
use App\Notifications\MessageReceived;
use App\Repository\ConversationRepository;
use App\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{

    private $conversationRepository;
    private $auth;

    public function __construct(ConversationRepository $conversationRepository, AuthManager $auth)
    {
        $this->middleware('auth');
        $this->conversationRepository = $conversationRepository;
        $this->auth = $auth;
    }

    public function index() {
        return view('conversations/index');
    }

    public function show(User $user) {
        $users = $this->conversationRepository->getConverastions($this->auth->user()->id);
        $messages = $this->conversationRepository->getMessagesFor($this->auth->user()->id, $user->id)->paginate(50);
        $unread = $this->conversationRepository->unreadCount($this->auth->user()->id);
        if(isset($unread[$user->id])) {
            $this->conversationRepository->readAllFrom($user->id, $this->auth->user()->id);
            unset($unread[$user->id]);
        }
        return view('conversations/show', compact('users', 'user', 'messages', 'unread'));
    }

    public function store(User $user, StoreMessage $request) {
        $message = $this->conversationRepository->createMessage($request->get('content'), $this->auth->user()->id, $user->id);
        //$user->notify(new MessageReceived($message));
        return redirect(route('conversations.show', ['user' => $user->id]));
    }
}
