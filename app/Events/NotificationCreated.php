<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Foundation\Events\Dispatchable;

class NotificationCreated
{
  use Dispatchable;

  public $notification;

  public function __construct(Notification $notification)
  {
    $this->notification = $notification;
  }
}
