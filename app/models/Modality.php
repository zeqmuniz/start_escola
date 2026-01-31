<?php

class Modality
{
    public static function all(): array
    {
        $db = App::db();
        return $db->fetchAll('SELECT * FROM modalities ORDER BY id DESC');
    }

    public static function find(int $id): ?array
    {
        $db = App::db();
        return $db->fetch('SELECT * FROM modalities WHERE id = :id', ['id' => $id]);
    }

    public static function create(array $data): int
    {
        $db = App::db();
        $db->execute(
            'INSERT INTO modalities (name, description, created_at) VALUES (:name, :description, NOW())',
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
            'UPDATE modalities SET name = :name, description = :description, updated_at = NOW() WHERE id = :id',
            [
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'id' => $id,
            ]
        );
    }
}
