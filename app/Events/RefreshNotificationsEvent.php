<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RefreshNotificationsEvent implements ShouldBroadcast
{
  use Dispatchable;

  public $userId;

  public function __construct($userId)
  {
    $this->userId = $userId;
  }

  public function broadcastOn()
  {
    return ['notifications.' . $this->userId];
  }
}
