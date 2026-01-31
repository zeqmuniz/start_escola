<?php

class Enrollment
{
    public static function create(array $data): int
    {
        $db = App::db();
        $db->execute(
            'INSERT INTO enrollments (person_id, module_id, pole_id, modality_id, status, created_at) VALUES (:person_id, :module_id, :pole_id, :modality_id, :status, NOW())',
            [
                'person_id' => $data['person_id'],
                'module_id' => $data['module_id'] ?? null,
                'pole_id' => $data['pole_id'] ?? null,
                'modality_id' => $data['modality_id'] ?? null,
                'status' => $data['status'] ?? 'cursando',
            ]
        );
        return (int) $db->lastInsertId();
    }
}
