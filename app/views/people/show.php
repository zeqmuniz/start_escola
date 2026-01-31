<h2 class="text-2xl font-semibold mb-4">Pessoa</h2>
<div class="rounded-xl border border-gray-100 p-4 space-y-2">
    <div><span class="text-gray-500 text-sm">Nome:</span> <strong><?= e($person['full_name']) ?></strong></div>
    <div><span class="text-gray-500 text-sm">Email:</span> <?= e($person['email'] ?? '-') ?></div>
    <div><span class="text-gray-500 text-sm">Telefone:</span> <?= e($person['phone'] ?? '-') ?></div>
    <div><span class="text-gray-500 text-sm">CPF:</span> <?= e($person['cpf'] ?? '-') ?></div>
    <div><span class="text-gray-500 text-sm">Nascimento:</span> <?= e($person['birth_date'] ?? '-') ?></div>
    <div><span class="text-gray-500 text-sm">Genero:</span> <?= e($person['gender'] ?? '-') ?></div>
</div>

<div class="mt-4">
    <a href="<?= url('admin/pessoas') ?>" class="px-4 py-2 rounded-xl border border-gray-200">Voltar</a>
</div>
