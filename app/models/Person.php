<?php

class Person
{
    public static function all(): array
    {
        $db = App::db();
        return $db->fetchAll('SELECT * FROM people ORDER BY id DESC');
    }

    public static function find(int $id): ?array
    {
        $db = App::db();
        return $db->fetch('SELECT * FROM people WHERE id = :id', ['id' => $id]);
    }

    public static function create(array $data): int
    {
        $db = App::db();
        $db->execute(
            'INSERT INTO people (full_name, cpf, email, phone, birth_date, gender, created_at) VALUES (:full_name, :cpf, :email, :phone, :birth_date, :gender, NOW())',
            [
                'full_name' => $data['full_name'],
                'cpf' => $data['cpf'] ?? null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'birth_date' => $data['birth_date'] ?? null,
                'gender' => $data['gender'] ?? null,
            ]
        );
        return (int) $db->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $db = App::db();
        $db->execute(
            'UPDATE people SET full_name = :full_name, cpf = :cpf, email = :email, phone = :phone, birth_date = :birth_date, gender = :gender, updated_at = NOW() WHERE id = :id',
            [
                'full_name' => $data['full_name'],
                'cpf' => $data['cpf'] ?? null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'birth_date' => $data['birth_date'] ?? null,
                'gender' => $data['gender'] ?? null,
                'id' => $id,
            ]
        );
    }
}
