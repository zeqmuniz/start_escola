<h2 class="text-2xl font-semibold mb-4">Nova modalidade</h2>
<form method="post" action="<?= url('admin/modalidades') ?>" class="space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium text-gray-700">Nome</label>
        <input type="text" name="name" value="<?= e(old('name')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Descricao</label>
        <textarea name="description" rows="3" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2"><?= e(old('description')) ?></textarea>
    </div>
    <div class="flex gap-3">
        <button class="px-4 py-2 rounded-xl bg-black text-white font-semibold">Salvar</button>
        <a href="<?= url('admin/modalidades') ?>" class="px-4 py-2 rounded-xl border border-gray-200">Cancelar</a>
    </div>
</form>
