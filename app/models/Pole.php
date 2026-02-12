<?php

class Pole
{
    public static function all(): array
    {
        $db = App::db();
        return $db->fetchAll(
            'SELECT p.*, u.display_name AS coordinator_name
             FROM poles p
             LEFT JOIN users u ON u.id = p.coordinator_user_id
             ORDER BY p.id DESC'
        );
    }

    public static function find(int $id): ?array
    {
        $db = App::db();
        return $db->fetch(
            'SELECT p.*, u.display_name AS coordinator_name
             FROM poles p
             LEFT JOIN users u ON u.id = p.coordinator_user_id
             WHERE p.id = :id',
            ['id' => $id]
        );
    }

    public static function findByCoordinator(int $userId): ?array
    {
        $db = App::db();
        return $db->fetch(
            'SELECT p.* FROM poles p WHERE p.coordinator_user_id = :id LIMIT 1',
            ['id' => $userId]
        );
    }

    public static function create(array $data): int
    {
        $db = App::db();
        $db->execute(
            'INSERT INTO poles (name, address, coordinator_user_id, status, created_at)
             VALUES (:name, :address, :coordinator_user_id, :status, NOW())',
            [
                'name' => $data['name'],
                'address' => $data['address'] ?? null,
                'coordinator_user_id' => $data['coordinator_user_id'] ?? null,
                'status' => $data['status'] ?? 'active',
            ]
        );
        return (int) $db->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $db = App::db();
        $db->execute(
            'UPDATE poles SET name = :name, address = :address, coordinator_user_id = :coordinator_user_id, status = :status, updated_at = NOW() WHERE id = :id',
            [
                'name' => $data['name'],
                'address' => $data['address'] ?? null,
                'coordinator_user_id' => $data['coordinator_user_id'] ?? null,
                'status' => $data['status'] ?? 'active',
                'id' => $id,
            ]
        );
    }

    public static function disable(int $id): void
    {
        $db = App::db();
        $db->execute('UPDATE poles SET status = :status, updated_at = NOW() WHERE id = :id', [
            'status' => 'disabled',
            'id' => $id,
        ]);
    }
}
