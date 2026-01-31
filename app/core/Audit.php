<?php

class Audit
{
    public static function log(string $action, string $entity, int $entityId, array $meta = []): void
    {
        $user = Auth::user();
        $db = App::db();
        $db->execute(
            'INSERT INTO audit_logs (user_id, action, entity, entity_id, meta_json, created_at) VALUES (:user_id, :action, :entity, :entity_id, :meta, NOW())',
            [
                'user_id' => $user ? $user['id'] : null,
                'action' => $action,
                'entity' => $entity,
                'entity_id' => $entityId,
                'meta' => json_encode($meta, JSON_UNESCAPED_UNICODE),
            ]
        );
    }
}
