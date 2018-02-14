<?php
namespace Grohiro\Laravel\FCM;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message;
use paragraph1\phpFCM\Recipient\Device;

/**
 * Firebase channel.
 * Setup paragraph1 client before using Firebase channel.
 *
 * ```
 * App::bind(\paragraph1\phpFCM\Client::class, function (\GuzzleHttp\Client $httpClient) {
 *   $apiKey = config('app.firebase.api_key');
 *   $client = new Client();
 *   $client->setApiKey($apiKey);
 *   $client->injectHttpClient($httpClient);
 *   return $client;
 * });
 * ```
 * @see https://github.com/Paragraph1/php-fcm
 */
class FirebaseChannel
{
  /**
   * @var \paragraph1\phpFCM\Client
   */
  protected $client;

  /**
   * @param \paragraph1\phpFCM\Client $client
   */
  public function __construct(Client $client)
  {
    $this->client = $client;
  }

  /**
   * @param \Illuminate\Notifications\Notifiable $notifiable
   * @param \Illuminate\Notifications\Notification $notification
   * @throws \Exception
   */
  public function send($notifiable, Notification $notification)
  {
    $messages = $notification->toFcmMessage($notifiable);
    if (!is_array($messages)) {
      $messages = [$messages];
    }
    foreach ($messages as $message) {
      $response = $this->client->send($message);
      if ($response->getStatusCode() !== 200) {
        throw new \Exception($errmsg, $response->getStatusCode());
      }
    }
  }
}
