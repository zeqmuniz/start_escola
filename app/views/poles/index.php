<h2 class="text-2xl font-semibold mb-4">Polos</h2>
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <p class="text-sm text-gray-600">Unidades administrativas.</p>
    <?php if (RBAC::can('poles.create')): ?>
        <a href="<?= url('admin/polos/novo') ?>" class="px-4 py-2 rounded-full bg-black text-white text-sm font-semibold">Novo polo</a>
    <?php endif; ?>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500">
                <th class="py-2">Nome</th>
                <th class="py-2">Endereco</th>
                <th class="py-2">Coordenador</th>
                <th class="py-2">Status</th>
                <th class="py-2"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php foreach ($poles as $pole): ?>
                <tr>
                    <td class="py-3 font-medium"><?= e($pole['name']) ?></td>
                    <td class="py-3"><?= e($pole['address'] ?? '-') ?></td>
                    <td class="py-3"><?= e($pole['coordinator_name'] ?? '-') ?></td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $pole['status'] === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' ?>">
                            <?= e($pole['status']) ?>
                        </span>
                    </td>
                    <td class="py-3 text-right space-x-3">
                        <?php if (RBAC::can('poles.update')): ?>
                            <a class="text-sm font-semibold text-amber-700" href="<?= url('admin/polos/' . $pole['id'] . '/editar') ?>">Editar</a>
                        <?php endif; ?>
                        <?php if (RBAC::can('poles.disable') && $pole['status'] === 'active'): ?>
                            <form method="post" action="<?= url('admin/polos/' . $pole['id'] . '/desativar') ?>" class="inline">
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
