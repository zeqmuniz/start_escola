<?php

return [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'name' => env('DB_NAME', ''),
    'user' => env('DB_USER', ''),
    'pass' => env('DB_PASS', ''),
    'charset' => env('DB_CHARSET', 'utf8mb4'),
];
