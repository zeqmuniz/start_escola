<?php

require __DIR__ . '/../app/bootstrap.php';

$config = require base_path('config/permissions.php');
$db = App::db();

foreach ($config['permissions'] as $slug => $description) {
    $exists = $db->fetch('SELECT id FROM permissions WHERE slug = :slug', ['slug' => $slug]);
    $db->execute(
        'INSERT IGNORE INTO permissions (slug, description, created_at) VALUES (:slug, :description, NOW())',
        ['slug' => $slug, 'description' => $description]
    );
}

foreach ($config['roles'] as $slug => $name) {
    $exists = $db->fetch('SELECT id FROM roles WHERE slug = :slug', ['slug' => $slug]);
    $db->execute(
        'INSERT IGNORE INTO roles (name, slug, description, created_at) VALUES (:name, :slug, :description, NOW())',
        ['name' => $name, 'slug' => $slug, 'description' => $name]
    );
}

$permRows = $db->fetchAll('SELECT id, slug FROM permissions');
$roleRows = $db->fetchAll('SELECT id, slug FROM roles');
$permMap = [];
$roleMap = [];
foreach ($permRows as $row) {
    $permMap[$row['slug']] = (int) $row['id'];
}
foreach ($roleRows as $row) {
    $roleMap[$row['slug']] = (int) $row['id'];
}

foreach ($config['role_permissions'] as $roleSlug => $perms) {
    $roleId = $roleMap[$roleSlug] ?? null;
    if (!$roleId) {
        continue;
    }
    foreach ($perms as $permSlug) {
        $permId = $permMap[$permSlug] ?? null;
        if (!$permId) {
            continue;
        }
        $db->execute(
            'INSERT IGNORE INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)',
            ['role_id' => $roleId, 'permission_id' => $permId]
        );
    }
}

$adminEmail = (string) env('ADMIN_EMAIL', 'admin@start.local');
$adminPassword = (string) env('ADMIN_PASSWORD', 'Admin@123!');
$adminUser = $db->fetch('SELECT id FROM users WHERE email = :email', ['email' => $adminEmail]);

if (!$adminUser) {
    $hash = password_hash($adminPassword, PASSWORD_BCRYPT);
    $db->execute(
        'INSERT INTO users (display_name, email, password_hash, status, must_change_password, created_at) VALUES (:name, :email, :hash, :status, :must_change, NOW())',
        [
            'name' => 'Administrador Geral',
            'email' => $adminEmail,
            'hash' => $hash,
            'status' => 'active',
            'must_change' => 0,
        ]
    );
    $userId = (int) $db->lastInsertId();
    $roleId = $roleMap['admin'] ?? null;
    if ($roleId) {
        $db->execute(
            'INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)',
            ['user_id' => $userId, 'role_id' => $roleId]
        );
    }
    echo "Admin criado: {$adminEmail}\n";
} else {
    echo "Admin ja existe: {$adminEmail}\n";
}

echo "Seed concluido.\n";
