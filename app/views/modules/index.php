<h2 class="text-2xl font-semibold mb-4">Modulos</h2>
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <p class="text-sm text-gray-600">Estrutura curricular por modulo.</p>
    <?php if (RBAC::can('modules.create')): ?>
        <a href="<?= url('admin/modulos/novo') ?>" class="px-4 py-2 rounded-full bg-black text-white text-sm font-semibold">Novo modulo</a>
    <?php endif; ?>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500">
                <th class="py-2">Nome</th>
                <th class="py-2">Descricao</th>
                <th class="py-2"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php foreach ($modules as $module): ?>
                <tr>
                    <td class="py-3 font-medium"><?= e($module['name']) ?></td>
                    <td class="py-3"><?= e($module['description'] ?? '-') ?></td>
                    <td class="py-3 text-right">
                        <?php if (RBAC::can('modules.update')): ?>
                            <a class="text-sm font-semibold text-amber-700" href="<?= url('admin/modulos/' . $module['id'] . '/editar') ?>">Editar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
