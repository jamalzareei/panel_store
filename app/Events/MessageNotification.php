<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class MessageNotification implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $message;

  public function __construct($message)
  {
      $this->message = $message;
  }

  public function broadcastOn()
  {
    // return new PrivateChannel("my-channel.{$this->message->user_receiver_id}");// $this->message->user_receiver_id
      return ["my-channel.{$this->message->user_receiver_id}"];
  }

  public function broadcastAs()
  {
      return 'my-event';
  }
}
