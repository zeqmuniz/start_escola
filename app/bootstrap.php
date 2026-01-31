<?php

define('BASE_PATH', dirname(__DIR__));

require __DIR__ . '/helpers.php';
load_env(base_path('.env'));
require base_path('app/autoload.php');

App::setConfig([
    'app' => require base_path('config/app.php'),
    'database' => require base_path('config/database.php'),
]);

date_default_timezone_set((string) config('app.timezone', 'America/Sao_Paulo'));

Session::start();

set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function ($exception) {
    $debug = (bool) config('app.debug', false);
    if ($debug) {
        http_response_code(500);
        echo '<pre>' . e((string) $exception) . '</pre>';
        return;
    }
    Response::abort(500, 'Ocorreu um erro inesperado.');
});
