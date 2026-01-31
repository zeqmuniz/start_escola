<?php

class RBAC
{
    public static function permissionsForUser(int $userId): array
    {
        $db = App::db();
        $rows = $db->fetchAll(
            'SELECT DISTINCT p.slug FROM permissions p
             INNER JOIN role_permissions rp ON rp.permission_id = p.id
             INNER JOIN user_roles ur ON ur.role_id = rp.role_id
             WHERE ur.user_id = :id',
            ['id' => $userId]
        );
        return array_map(fn($row) => $row['slug'], $rows);
    }

    public static function can(string $permission): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }
        $cache = Session::get('perm_cache');
        if (!$cache || ($cache['user_id'] ?? null) !== (int) $user['id']) {
            $perms = self::permissionsForUser((int) $user['id']);
            $cache = ['user_id' => (int) $user['id'], 'permissions' => $perms];
            Session::put('perm_cache', $cache);
        }
        return in_array($permission, $cache['permissions'] ?? [], true);
    }

    public static function require(string $permission): void
    {
        if (!self::can($permission)) {
            Response::abort(403, 'Acesso negado.');
        }
    }
}
