<?php

class Response
{
    public static function abort(int $code, string $message = ''): void
    {
        http_response_code($code);
        $view = 'errors/' . $code;
        if (!file_exists(base_path('app/views/' . $view . '.php'))) {
            echo $message !== '' ? e($message) : 'Erro.';
            exit;
        }
        View::render($view, ['message' => $message], 'layouts/guest');
        exit;
    }
}
