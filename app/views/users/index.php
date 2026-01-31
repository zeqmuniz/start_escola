<h2 class="text-2xl font-semibold mb-4">Usuarios</h2>
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <p class="text-sm text-gray-600">Controle de acesso e perfis.</p>
    <?php if (RBAC::can('users.create')): ?>
        <a href="<?= url('admin/usuarios/novo') ?>" class="px-4 py-2 rounded-full bg-black text-white text-sm font-semibold">Novo usuario</a>
    <?php endif; ?>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500">
                <th class="py-2">Nome</th>
                <th class="py-2">Email</th>
                <th class="py-2">Perfil</th>
                <th class="py-2">Status</th>
                <th class="py-2"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php foreach ($users as $user): ?>
                <tr>
                    <td class="py-3 font-medium"><?= e($user['display_name'] ?? '-') ?></td>
                    <td class="py-3"><?= e($user['email']) ?></td>
                    <td class="py-3"><?= e($user['roles'] ?? '-') ?></td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $user['status'] === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' ?>">
                            <?= e($user['status']) ?>
                        </span>
                    </td>
                    <td class="py-3 text-right space-x-3">
                        <?php if (RBAC::can('users.update')): ?>
                            <a class="text-sm font-semibold text-amber-700" href="<?= url('admin/usuarios/' . $user['id'] . '/editar') ?>">Editar</a>
                        <?php endif; ?>
                        <?php if (RBAC::can('users.disable') && $user['status'] === 'active'): ?>
                            <form method="post" action="<?= url('admin/usuarios/' . $user['id'] . '/desativar') ?>" class="inline">
                                <?= csrf_field() ?>
                                <button class="text-sm font-semibold text-rose-700">Desativar</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
