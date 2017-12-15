<?php

namespace Grohiro\Laravel\FCM;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use \paragraph1\phpFCM\Client as FcmClient;

class ServiceProvider extends LaravelServiceProvider
{
  public function boot()
  {
    \App::bind(FcmClient::class, function ($app) {
      $apiKey = config('app.firebase.api_key');
      $client = new FcmClient();
      $client->setApiKey($apiKey);
      $client->injectHttpClient($app->make(\GuzzleHttp\Client::class));
      return $client;
    });
  }
}
