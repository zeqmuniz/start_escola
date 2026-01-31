<?php

class Inscription
{
    public static function createPublic(array $data): int
    {
        $db = App::db();
        $db->execute(
            'INSERT INTO inscriptions (full_name, cpf, email, phone, module_id, pole_id, modality_id, status, created_at) VALUES (:full_name, :cpf, :email, :phone, :module_id, :pole_id, :modality_id, :status, NOW())',
            [
                'full_name' => $data['full_name'],
                'cpf' => $data['cpf'] ?? null,
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'module_id' => $data['module_id'] ?? null,
                'pole_id' => $data['pole_id'] ?? null,
                'modality_id' => $data['modality_id'] ?? null,
                'status' => 'pending',
            ]
        );
        return (int) $db->lastInsertId();
    }

    public static function all(): array
    {
        $db = App::db();
        return $db->fetchAll(
            'SELECT i.*, m.name AS module_name, p.name AS pole_name, mo.name AS modality_name
             FROM inscriptions i
             LEFT JOIN modules m ON m.id = i.module_id
             LEFT JOIN poles p ON p.id = i.pole_id
             LEFT JOIN modalities mo ON mo.id = i.modality_id
             ORDER BY i.id DESC'
        );
    }

    public static function find(int $id): ?array
    {
        $db = App::db();
        return $db->fetch(
            'SELECT i.*, m.name AS module_name, p.name AS pole_name, mo.name AS modality_name
             FROM inscriptions i
             LEFT JOIN modules m ON m.id = i.module_id
             LEFT JOIN poles p ON p.id = i.pole_id
             LEFT JOIN modalities mo ON mo.id = i.modality_id
             WHERE i.id = :id',
            ['id' => $id]
        );
    }

    public static function pendingCount(): int
    {
        $db = App::db();
        $row = $db->fetch('SELECT COUNT(*) as total FROM inscriptions WHERE status = :status', ['status' => 'pending']);
        return (int) ($row['total'] ?? 0);
    }

    public static function review(int $id, string $notes, int $userId): void
    {
        $db = App::db();
        $db->execute(
            'UPDATE inscriptions SET review_notes = :notes, updated_at = NOW() WHERE id = :id AND status = :status',
            [
                'notes' => $notes,
                'id' => $id,
                'status' => 'pending',
            ]
        );
        Audit::log('review', 'inscription', $id, ['notes' => $notes, 'user_id' => $userId]);
    }

    public static function reject(int $id, string $reason, int $userId): void
    {
        $db = App::db();
        $db->execute(
            'UPDATE inscriptions SET status = :status, rejection_reason = :reason, decided_by_user_id = :user_id, decided_at = NOW(), updated_at = NOW() WHERE id = :id AND status = :pending',
            [
                'status' => 'rejected',
                'reason' => $reason,
                'user_id' => $userId,
                'id' => $id,
                'pending' => 'pending',
            ]
        );
        Audit::log('reject', 'inscription', $id, ['reason' => $reason, 'user_id' => $userId]);
    }

    public static function findDuplicate(string $email, ?string $cpf = null): array
    {
        $db = App::db();
        $params = ['email' => $email, 'cpf' => $cpf];
        $person = $db->fetch(
            'SELECT * FROM people WHERE email = :email OR (:cpf IS NOT NULL AND cpf = :cpf) LIMIT 1',
            $params
        );
        $user = $db->fetch('SELECT * FROM users WHERE email = :email LIMIT 1', ['email' => $email]);
        return ['person' => $person, 'user' => $user];
    }
}
