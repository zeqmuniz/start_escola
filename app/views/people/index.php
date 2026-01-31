<h2 class="text-2xl font-semibold mb-4">Pessoas</h2>
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <p class="text-sm text-gray-600">Cadastro base de membros, alunos e professores.</p>
    <?php if (RBAC::can('people.create')): ?>
        <a href="<?= url('admin/pessoas/novo') ?>" class="px-4 py-2 rounded-full bg-black text-white text-sm font-semibold">Nova pessoa</a>
    <?php endif; ?>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500">
                <th class="py-2">Nome</th>
                <th class="py-2">Email</th>
                <th class="py-2">Telefone</th>
                <th class="py-2"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php foreach ($people as $person): ?>
                <tr>
                    <td class="py-3 font-medium"><?= e($person['full_name']) ?></td>
                    <td class="py-3"><?= e($person['email'] ?? '-') ?></td>
                    <td class="py-3"><?= e($person['phone'] ?? '-') ?></td>
                    <td class="py-3 text-right space-x-3">
                        <a class="text-sm font-semibold text-amber-700" href="<?= url('admin/pessoas/' . $person['id']) ?>">Ver</a>
                        <?php if (RBAC::can('people.update')): ?>
                            <a class="text-sm font-semibold text-amber-700" href="<?= url('admin/pessoas/' . $person['id'] . '/editar') ?>">Editar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
