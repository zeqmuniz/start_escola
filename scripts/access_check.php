<?php

require __DIR__ . '/../app/bootstrap.php';

$config = require base_path('config/permissions.php');
$db = App::db();

$roles = $db->fetchAll('SELECT id, slug FROM roles');
$permissions = $db->fetchAll('SELECT id, slug FROM permissions');
$roleMap = [];
foreach ($roles as $role) {
    $roleMap[$role['slug']] = (int) $role['id'];
}

$permMap = [];
foreach ($permissions as $perm) {
    $permMap[$perm['slug']] = (int) $perm['id'];
}

$issues = 0;
foreach ($config['role_permissions'] as $roleSlug => $expectedPerms) {
    $roleId = $roleMap[$roleSlug] ?? null;
    if (!$roleId) {
        echo "Role ausente: {$roleSlug}\n";
        $issues++;
        continue;
    }

    $rows = $db->fetchAll(
        'SELECT p.slug FROM permissions p INNER JOIN role_permissions rp ON rp.permission_id = p.id WHERE rp.role_id = :role_id',
        ['role_id' => $roleId]
    );
    $currentPerms = array_map(fn($row) => $row['slug'], $rows);

    $missing = array_diff($expectedPerms, $currentPerms);
    $extra = array_diff($currentPerms, $expectedPerms);

    if (!empty($missing)) {
        echo "Role {$roleSlug} faltando: " . implode(', ', $missing) . "\n";
        $issues++;
    }
    if (!empty($extra)) {
        echo "Role {$roleSlug} extras: " . implode(', ', $extra) . "\n";
        $issues++;
    }
}

if ($issues === 0) {
    echo "Permissoes alinhadas com a matriz.\n";
}
