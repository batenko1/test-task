<?php

return [
    'brokers' => 'kafka:9092', // Указываем имя сервиса из docker-compose.yml
    'group_id' => env('KAFKA_GROUP_ID', 'laravel-group'),
    'topics' => [
        'default' => 'my-topic',
    ],
];
