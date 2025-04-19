<?php

namespace App\Livewire;

use App\Services\ChatService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class ChatInterface extends Component
{
  use WithPagination;

  public string $message = '';
  public $messages = [];
  public $loading = false;
  public $isOpen = false;
  public $error = null;
  public $typingTimeout = null;
  public $perPage = 10;

  // Rate limiting properties
  private $lastMessageTime = 0;
  private $minTimeBetweenMessages = 1; // seconds

  protected $listeners = [
    'toggleChat' => 'toggle',
    'refresh' => 'loadMessages',
    'newMessageReceived' => 'handleNewMessage'
  ];

  protected $rules = [
    'message' => 'required|string|max:1000',
  ];

  public function toggle()
  {
    $this->isOpen = !$this->isOpen;

    if ($this->isOpen) {
      $this->loadMessages();
    }
  }

  public function mount()
  {
    if (Auth::check()) {
      $this->loadMessages();
    }
  }

  public function loadMessages()
  {
    if (!Auth::check()) {
      $this->error = 'Please log in to view messages.';
      return;
    }

    try {
      $this->messages = Auth::user()
        ->chatMessages()
        ->with('user')
        ->latest()
        ->take($this->perPage)
        ->get()
        ->reverse()
        ->values()
        ->toArray();
      $this->error = null;
      $this->dispatch('messageReceived');
    } catch (\Exception $e) {
      $this->error = 'Failed to load messages. Please refresh the page.';
      $this->dispatch('notify', [
        'type' => 'error',
        'message' => 'Failed to load messages'
      ]);
    }
  }

  public function loadMoreMessages()
  {
    $this->perPage += 10;
    $this->loadMessages();
  }

  public function handleNewMessage()
  {
    $this->loadMessages();
  }

  public function sendMessage()
  {
    if (!Auth::check()) {
      $this->error = 'Please log in to send messages.';
      return;
    }

    // Rate limiting check
    $now = time();
    if ($now - $this->lastMessageTime < $this->minTimeBetweenMessages) {
      $this->error = 'Please wait a moment before sending another message.';
      return;
    }

    $this->validate();

    if (empty(trim($this->message))) {
      return;
    }

    $this->loading = true;
    $this->error = null;

    try {
      $chatService = app(ChatService::class);
      $response = $chatService->sendMessage(Auth::user(), $this->message);

      // Add the new message to the messages array
      $this->messages[] = array_merge($response->toArray(), ['user' => Auth::user()->toArray()]);

      $this->dispatch('chatMessageSent');
      $this->message = '';
      $this->lastMessageTime = time();

      // Load the AI response after a short delay
      $this->dispatch('refresh');
    } catch (\Exception $e) {
      $this->error = 'Failed to send message: ' . $e->getMessage();
      $this->dispatch('notify', [
        'type' => 'error',
        'message' => 'Failed to send message'
      ]);
    } finally {
      $this->loading = false;
    }
  }

  public function render()
  {
    return view('livewire.chat-interface');
  }
}
