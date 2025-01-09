<?php

use Illuminate\Support\Facades\Route;
use denis660\Centrifugo\Centrifugo;

Route::get('/', function () {
    echo 'vlad';
//    $producer = app(\App\Kafka\ProducerService::class);
//    $producer->sendMessage('Test message from Laravel with Docker');

//    $rabbitMQ = new \App\RabbitMQ\MessageService();
//    $rabbitMQ->publish('Hello, RabbitMQ! vlados', 'test-queue');
//    $rabbitMQ->close();


//    $response = Http::withHeaders([
//        'Content-Type' => 'application/json',
//        'X-API-Key' => 'my_api_key',
//    ])
//        ->post('http://host.docker.internal:8000/api/publish', [
//            'channel' => 'channel',
//            'data' => ['value' => 2],
//        ]);
});


Route::get('/test-broadcast', function (Centrifugo $centrifugo) {


    $centrifugo->publish('channel', ['message' => now()]);
    echo 'sending';
});


Route::get('/test', \App\Http\Controllers\TestController::class);
