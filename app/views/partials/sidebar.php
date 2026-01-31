<?php
$navItem = function (string $label, string $path, string $icon = '>') {
    $active = is_active($path);
    $base = 'flex items-center gap-2 px-3 py-2 rounded-xl text-sm transition';
    $classes = $active ? $base . ' bg-white text-sidebar font-semibold' : $base . ' text-white/80 hover:text-white hover:bg-sidebarLight';
    echo '<a class="' . $classes . '" href="' . e(url(ltrim($path, '/'))) . '"><span class="text-accent">' . e($icon) . '</span>' . e($label) . '</a>';
};
?>
<div class="mb-6">
    <div class="text-xs uppercase tracking-wider text-white/60">Menu</div>
</div>
<div class="space-y-1">
    <?php $navItem('Dashboard', '/dashboard', '#'); ?>
    <?php if (RBAC::can('inscriptions.view_any')): ?>
        <?php $navItem('Inscricoes', '/admin/inscricoes', '!'); ?>
    <?php endif; ?>
    <?php if (RBAC::can('people.view_any')): ?>
        <?php $navItem('Pessoas', '/admin/pessoas', '+'); ?>
    <?php endif; ?>
    <?php if (RBAC::can('users.view_any')): ?>
        <?php $navItem('Usuarios', '/admin/usuarios', '*'); ?>
    <?php endif; ?>
    <?php if (RBAC::can('poles.view_any')): ?>
        <?php $navItem('Polos', '/admin/polos', '@'); ?>
    <?php endif; ?>
    <?php if (RBAC::can('modules.view_any')): ?>
        <?php $navItem('Modulos', '/admin/modulos', '='); ?>
    <?php endif; ?>
    <?php if (RBAC::can('modalities.view_any')): ?>
        <?php $navItem('Modalidades', '/admin/modalidades', '^'); ?>
    <?php endif; ?>
    <?php $navItem('Minha conta', '/minha-conta', ':'); ?>
</div>
