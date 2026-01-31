<h2 class="text-2xl font-semibold mb-4">Editar polo</h2>
<form method="post" action="<?= url('admin/polos/' . $pole['id']) ?>" class="space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium text-gray-700">Nome</label>
        <input type="text" name="name" value="<?= e(old('name', $pole['name'] ?? '')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Endereco</label>
        <input type="text" name="address" value="<?= e(old('address', $pole['address'] ?? '')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
            <option value="active" <?= (old('status', $pole['status'] ?? '') === 'active') ? 'selected' : '' ?>>Ativo</option>
            <option value="disabled" <?= (old('status', $pole['status'] ?? '') === 'disabled') ? 'selected' : '' ?>>Desativado</option>
        </select>
    </div>
    <div class="flex gap-3">
        <button class="px-4 py-2 rounded-xl bg-black text-white font-semibold">Salvar</button>
        <a href="<?= url('admin/polos') ?>" class="px-4 py-2 rounded-xl border border-gray-200">Cancelar</a>
    </div>
</form>
