<h2 class="text-2xl font-semibold mb-4">Editar usuario</h2>
<form method="post" action="<?= url('admin/usuarios/' . $user['id']) ?>" class="space-y-4">
    <?= csrf_field() ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" name="display_name" value="<?= e(old('display_name', $user['display_name'] ?? '')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="<?= e(old('email', $user['email'] ?? '')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2" required>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nova senha (opcional)</label>
            <input type="password" name="password" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2" placeholder="Deixe vazio para manter">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Pessoa vinculada</label>
            <select name="person_id" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
                <option value="">Sem vinculo</option>
                <?php foreach ($people as $person): ?>
                    <option value="<?= e($person['id']) ?>" <?= (old('person_id', $user['person_id'] ?? '') == $person['id']) ? 'selected' : '' ?>><?= e($person['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
            <option value="active" <?= (old('status', $user['status'] ?? '') === 'active') ? 'selected' : '' ?>>Ativo</option>
            <option value="disabled" <?= (old('status', $user['status'] ?? '') === 'disabled') ? 'selected' : '' ?>>Desativado</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Perfis</label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <?php $selectedRoles = array_map(fn($r) => $r['id'], $user['roles'] ?? []); ?>
            <?php $oldRoles = old('roles', $selectedRoles); if (!is_array($oldRoles)) { $oldRoles = [$oldRoles]; } ?>
            <?php foreach ($roles as $role): ?>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="roles[]" value="<?= e($role['id']) ?>" <?= in_array($role['id'], $oldRoles) ? 'checked' : '' ?>>
                    <?= e($role['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="flex gap-3">
        <button class="px-4 py-2 rounded-xl bg-black text-white font-semibold">Salvar</button>
        <a href="<?= url('admin/usuarios') ?>" class="px-4 py-2 rounded-xl border border-gray-200">Cancelar</a>
    </div>
</form>
