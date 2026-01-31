<?php

class Module
{
    public static function all(): array
    {
        $db = App::db();
        return $db->fetchAll('SELECT * FROM modules ORDER BY id DESC');
    }

    public static function find(int $id): ?array
    {
        $db = App::db();
        return $db->fetch('SELECT * FROM modules WHERE id = :id', ['id' => $id]);
    }

    public static function create(array $data): int
    {
        $db = App::db();
        $db->execute(
            'INSERT INTO modules (name, description, created_at) VALUES (:name, :description, NOW())',
            [
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]
        );
        return (int) $db->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $db = App::db();
        $db->execute(
            'UPDATE modules SET name = :name, description = :description, updated_at = NOW() WHERE id = :id',
            [
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'id' => $id,
            ]
        );
    }
}
