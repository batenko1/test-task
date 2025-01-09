<?php

return [
    'token_hmac_secret_key' => env('CENTRIFUGO_TOKEN_HMAC_SECRET_KEY', 'my_secret'),
    'secret' => env('CENTRIFUGO_TOKEN_HMAC_SECRET_KEY', 'my_secret'),
    'api_key' => env('CENTRIFUGO_API_KEY', ''),
    'url' => env('CENTRIFUGO_HOST', 'http://localhost:8000'),
    'admin_password' => env('CENTRIFUGO_ADMIN_PASSWORD', ''),
    'admin_secret' => env('CENTRIFUGO_ADMIN_SECRET', ''),
];
