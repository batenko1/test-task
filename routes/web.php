<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $producer = app(\App\Kafka\ProducerService::class);
    $producer->sendMessage('Test message from Laravel with Docker');
});
