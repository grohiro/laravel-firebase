<?php

namespace Grohiro\Laravel\FCM;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class LogChannel
{
  public function send($notifiable, Notification $notification)
  {
    if (!($notification instanceof PushNotification)) {
      throw new \Exception('The notification must be subclass of PushNotification.');
    }

    $messages = $notification->toFcmMessage($notifiable);
    if (!is_array($messages)) {
      $messages = [$messages];
    }
    foreach ($messages as $message) {
      Log::info(sprintf("Notifiable: %s, Message: %s", json_encode($notifiable), json_encode($message)));
    }
  }
}
