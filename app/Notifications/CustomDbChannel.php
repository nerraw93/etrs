<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class CustomDbChannel
{

  public function send($notifiable, Notification $notification)
  {
    $data = $notification->toDatabase($notifiable);

    if (auth()->check()) {
        $user_id = auth()->user()->id;
    } else {
        $user_id = $data['user_id'];
    }
    
    return $notifiable->routeNotificationFor('database')->create([
        'id' => $notification->id,
        'batch_id' => $data['batch_id'],
        'notifiable_id'=> $user_id,
        'type' => get_class($notification),
        'data' => $data,
        'read_at' => null,
    ]);
  }

}
