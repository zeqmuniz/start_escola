<?php

class Pole
{
    public static function all(): array
    {
        $db = App::db();
        return $db->fetchAll('SELECT * FROM poles ORDER BY id DESC');
    }

    public static function find(int $id): ?array
    {
        $db = App::db();
        return $db->fetch('SELECT * FROM poles WHERE id = :id', ['id' => $id]);
    }

    public static function create(array $data): int
    {
        $db = App::db();
        $db->execute(
            'INSERT INTO poles (name, address, status, created_at) VALUES (:name, :address, :status, NOW())',
            [
                'name' => $data['name'],
                'address' => $data['address'] ?? null,
                'status' => $data['status'] ?? 'active',
            ]
        );
        return (int) $db->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $db = App::db();
        $db->execute(
            'UPDATE poles SET name = :name, address = :address, status = :status, updated_at = NOW() WHERE id = :id',
            [
                'name' => $data['name'],
                'address' => $data['address'] ?? null,
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
