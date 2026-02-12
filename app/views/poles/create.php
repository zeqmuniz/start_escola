<h2 class="text-2xl font-semibold mb-4">Novo polo</h2>
<form method="post" action="<?= url('admin/polos') ?>" class="space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium text-gray-700">Nome</label>
        <input type="text" name="name" value="<?= e(old('name')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Endereco</label>
        <input type="text" name="address" value="<?= e(old('address')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Coordenador do polo</label>
        <select name="coordinator_user_id" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
            <option value="">Sem coordenador</option>
            <?php foreach ($coordinators as $coordinator): ?>
                <option value="<?= e($coordinator['id']) ?>" <?= old('coordinator_user_id') == $coordinator['id'] ? 'selected' : '' ?>>
                    <?= e($coordinator['display_name'] ?: $coordinator['email']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
            <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Ativo</option>
            <option value="disabled" <?= old('status') === 'disabled' ? 'selected' : '' ?>>Desativado</option>
        </select>
    </div>
    <div class="flex gap-3">
        <button class="px-4 py-2 rounded-xl bg-black text-white font-semibold">Salvar</button>
        <a href="<?= url('admin/polos') ?>" class="px-4 py-2 rounded-xl border border-gray-200">Cancelar</a>
    </div>
</form>
