<?php

class User
{
    public static function all(): array
    {
        $db = App::db();
        return $db->fetchAll(
            'SELECT u.*, GROUP_CONCAT(r.name SEPARATOR ", ") as roles
             FROM users u
             LEFT JOIN user_roles ur ON ur.user_id = u.id
             LEFT JOIN roles r ON r.id = ur.role_id
             GROUP BY u.id
             ORDER BY u.id DESC'
        );
    }

    public static function find(int $id): ?array
    {
        $db = App::db();
        return $db->fetch('SELECT * FROM users WHERE id = :id', ['id' => $id]);
    }

    public static function findWithRoles(int $id): ?array
    {
        $db = App::db();
        $user = $db->fetch('SELECT * FROM users WHERE id = :id', ['id' => $id]);
        if (!$user) {
            return null;
        }
        $roles = $db->fetchAll(
            'SELECT r.* FROM roles r INNER JOIN user_roles ur ON ur.role_id = r.id WHERE ur.user_id = :id',
            ['id' => $id]
        );
        $user['roles'] = $roles;
        return $user;
    }

    public static function create(array $data, array $roleIds): int
    {
        $db = App::db();
        $db->execute(
            'INSERT INTO users (person_id, display_name, email, password_hash, status, must_change_password, created_at)
             VALUES (:person_id, :display_name, :email, :password_hash, :status, :must_change_password, NOW())',
            [
                'person_id' => $data['person_id'] ?? null,
                'display_name' => $data['display_name'] ?? null,
                'email' => $data['email'],
                'password_hash' => $data['password_hash'],
                'status' => $data['status'] ?? 'active',
                'must_change_password' => $data['must_change_password'] ?? 0,
            ]
        );
        $userId = (int) $db->lastInsertId();
        self::setRoles($userId, $roleIds);
        return $userId;
    }

    public static function update(int $id, array $data, ?array $roleIds = null): void
    {
        $db = App::db();
        $db->execute(
            'UPDATE users SET person_id = :person_id, display_name = :display_name, email = :email, status = :status, must_change_password = :must_change_password, updated_at = NOW() WHERE id = :id',
            [
                'person_id' => $data['person_id'] ?? null,
                'display_name' => $data['display_name'] ?? null,
                'email' => $data['email'],
                'status' => $data['status'] ?? 'active',
                'must_change_password' => $data['must_change_password'] ?? 0,
                'id' => $id,
            ]
        );
        if ($data['password_hash'] ?? null) {
            $db->execute(
                'UPDATE users SET password_hash = :password_hash WHERE id = :id',
                ['password_hash' => $data['password_hash'], 'id' => $id]
            );
        }
        if ($roleIds !== null) {
            self::setRoles($id, $roleIds);
        }
    }

    public static function setRoles(int $userId, array $roleIds): void
    {
        $db = App::db();
        $db->execute('DELETE FROM user_roles WHERE user_id = :id', ['id' => $userId]);
        foreach ($roleIds as $roleId) {
            $db->execute(
                'INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)',
                ['user_id' => $userId, 'role_id' => $roleId]
            );
        }
    }

    public static function disable(int $id): void
    {
        $db = App::db();
        $db->execute('UPDATE users SET status = :status, updated_at = NOW() WHERE id = :id', [
            'status' => 'disabled',
            'id' => $id,
        ]);
    }

    public static function rolesOptions(): array
    {
        $db = App::db();
        return $db->fetchAll('SELECT id, name, slug FROM roles ORDER BY name');
    }
}
