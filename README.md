# laravel-firebase

Firebase Channel plugin for Laravel.

```php
use Illuminate\Notifications\Notification;
use Grohiro\Laravel\FCM\FirebaseChannel;
use paragraph1\phpFCM\Message;
use paragraph1\phpFCM\Recipient\Device;
use paragraph1\phpFCM\Notification;

/**
 * @see https://laravel.com/docs/5.5/notifications#custom-channels
 */
class PushMessage extends Notification
{
  public function via($notifiable)
  {
    return [FirebaseChannel::class];
  }
  
  public function toFcmMessage($user)
  {
    // @see https://github.com/Paragraph1/php-fcm
    $note = new Notification('test title', 'testing body');
    $note->setIcon('notification_icon_resource_name')
        ->setColor('#ffffff')
        ->setBadge(1);
    $message = new Message();
    $message->addRecipient(new Device($user->user_device_token));
    $message->setNotification($note)
            ->setData(array('someId' => 111));
    return $message;
  }
}
```

## Requirements

- Laravel 5.5+
- [paragraph1/php-fcm](https://github.com/Paragraph1/php-fcm)

## Usage

### 1. Install laravel-firebase

```bash
$ composer require grohiro/laravel-firebase dev-master
```

### 2. Setup Guzzle HTTP client

Add the ServiceProvider to `app.php`

```php
// config/app.php
'providers' => [
  \Grohiro\Laravel\FCM\ServiceProvider::class,
];
```

### 3. Create Laravel Notification class

```
php artisan make:notification PushNotification
```

### 4. Set Firebase API key

```php
// config/app.php
'firebase' => [
  'api_key' => 'your-api-key'
],
```
