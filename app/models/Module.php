<?php

class Module
{
    public static function all(): array
    {
        $db = App::db();
        return $db->fetchAll('SELECT * FROM modules ORDER BY sort_order ASC, id ASC');
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
            'INSERT INTO modules (name, sort_order, description, created_at) VALUES (:name, :sort_order, :description, NOW())',
            [
                'name' => $data['name'],
                'sort_order' => (int) ($data['sort_order'] ?? 0),
                'description' => $data['description'] ?? null,
            ]
        );
        return (int) $db->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $db = App::db();
        $db->execute(
            'UPDATE modules SET name = :name, sort_order = :sort_order, description = :description, updated_at = NOW() WHERE id = :id',
            [
                'name' => $data['name'],
                'sort_order' => (int) ($data['sort_order'] ?? 0),
                'description' => $data['description'] ?? null,
                'id' => $id,
            ]
        );
    }
}
