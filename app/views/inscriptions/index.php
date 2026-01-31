<h2 class="text-2xl font-semibold mb-4">Inscricoes</h2>
<p class="text-sm text-gray-600 mb-6">Acompanhe pedidos pendentes e registros decididos.</p>

<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500">
                <th class="py-2">ID</th>
                <th class="py-2">Nome</th>
                <th class="py-2">Email</th>
                <th class="py-2">Modulo</th>
                <th class="py-2">Polo</th>
                <th class="py-2">Status</th>
                <th class="py-2"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php foreach ($inscriptions as $inscription): ?>
                <tr>
                    <td class="py-3">#<?= e($inscription['id']) ?></td>
                    <td class="py-3 font-medium"><?= e($inscription['full_name']) ?></td>
                    <td class="py-3"><?= e($inscription['email']) ?></td>
                    <td class="py-3"><?= e($inscription['module_name'] ?? '-') ?></td>
                    <td class="py-3"><?= e($inscription['pole_name'] ?? '-') ?></td>
                    <td class="py-3">
                        <?php $status = $inscription['status']; ?>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            <?= $status === 'pending' ? 'bg-amber-100 text-amber-800' : '' ?>
                            <?= $status === 'approved' ? 'bg-emerald-100 text-emerald-800' : '' ?>
                            <?= $status === 'rejected' ? 'bg-rose-100 text-rose-800' : '' ?>">
                            <?= e($status) ?>
                        </span>
                    </td>
                    <td class="py-3 text-right">
                        <a class="text-sm font-semibold text-amber-700" href="<?= url('admin/inscricoes/' . $inscription['id']) ?>">Ver</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
