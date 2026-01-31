<?php

function base_path(string $path = ''): string
{
    $base = dirname(__DIR__);
    if ($path === '') {
        return $base;
    }
    return $base . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
}

function load_env(string $path): void
{
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }
        $key = trim($parts[0]);
        $value = trim($parts[1]);
        if ($value !== '' && ($value[0] === '"' || $value[0] === "'")) {
            $value = trim($value, "\"'");
        }
        $_ENV[$key] = $value;
        putenv($key . '=' . $value);
    }
}

function env(string $key, $default = null)
{
    if (array_key_exists($key, $_ENV)) {
        return $_ENV[$key];
    }
    $value = getenv($key);
    return $value !== false ? $value : $default;
}

function config(string $key, $default = null)
{
    return App::config($key, $default);
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function url(string $path = ''): string
{
    $base = rtrim((string) config('app.url', ''), '/');
    if ($path === '') {
        return $base;
    }
    return $base . '/' . ltrim($path, '/');
}

function csrf_token(): string
{
    return Csrf::token();
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function flash(string $key, $value = null)
{
    return Session::flash($key, $value);
}

function old(string $key, $default = '')
{
    return Session::old($key, $default);
}

function set_old_input(array $data): void
{
    Session::setOld($data);
}

function is_active(string $path): bool
{
    $current = Request::path();
    $path = '/' . trim($path, '/');
    if ($path === '/') {
        return $current === '/';
    }
    return str_starts_with($current, $path);
}
