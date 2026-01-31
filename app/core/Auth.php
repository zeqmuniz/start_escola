<?php

class Auth
{
    private static ?array $user = null;

    public static function attempt(string $email, string $password): bool
    {
        $db = App::db();
        $user = $db->fetch('SELECT * FROM users WHERE email = :email LIMIT 1', ['email' => $email]);
        if (!$user || ($user['status'] ?? '') !== 'active') {
            return false;
        }
        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }
        Session::put('user_id', (int) $user['id']);
        Session::forget('perm_cache');
        Session::regenerate();
        self::$user = $user;
        return true;
    }

    public static function user(): ?array
    {
        if (self::$user !== null) {
            return self::$user;
        }
        $userId = Session::get('user_id');
        if (!$userId) {
            return null;
        }
        $db = App::db();
        $user = $db->fetch('SELECT * FROM users WHERE id = :id LIMIT 1', ['id' => $userId]);
        if (!$user || ($user['status'] ?? '') !== 'active') {
            self::logout();
            return null;
        }
        self::$user = $user;
        return $user;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function logout(): void
    {
        Session::forget('user_id');
        Session::forget('perm_cache');
        Session::regenerate();
        self::$user = null;
    }

    public static function roles(): array
    {
        $user = self::user();
        if (!$user) {
            return [];
        }
        $db = App::db();
        return $db->fetchAll(
            'SELECT r.* FROM roles r INNER JOIN user_roles ur ON ur.role_id = r.id WHERE ur.user_id = :id',
            ['id' => $user['id']]
        );
    }
}
