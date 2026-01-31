<h2 class="text-2xl font-semibold mb-4">Modalidades</h2>
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <p class="text-sm text-gray-600">Modalidades de estudo disponiveis.</p>
    <?php if (RBAC::can('modalities.create')): ?>
        <a href="<?= url('admin/modalidades/novo') ?>" class="px-4 py-2 rounded-full bg-black text-white text-sm font-semibold">Nova modalidade</a>
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
            <?php foreach ($modalities as $modality): ?>
                <tr>
                    <td class="py-3 font-medium"><?= e($modality['name']) ?></td>
                    <td class="py-3"><?= e($modality['description'] ?? '-') ?></td>
                    <td class="py-3 text-right">
                        <?php if (RBAC::can('modalities.update')): ?>
                            <a class="text-sm font-semibold text-amber-700" href="<?= url('admin/modalidades/' . $modality['id'] . '/editar') ?>">Editar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
