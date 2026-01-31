<h2 class="text-2xl font-semibold mb-4">Editar pessoa</h2>
<form method="post" action="<?= url('admin/pessoas/' . $person['id']) ?>" class="space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium text-gray-700">Nome completo</label>
        <input type="text" name="full_name" value="<?= e(old('full_name', $person['full_name'] ?? '')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2" required>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">CPF</label>
            <input type="text" name="cpf" value="<?= e(old('cpf', $person['cpf'] ?? '')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Telefone</label>
            <input type="text" name="phone" value="<?= e(old('phone', $person['phone'] ?? '')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="<?= e(old('email', $person['email'] ?? '')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Data de nascimento</label>
            <input type="date" name="birth_date" value="<?= e(old('birth_date', $person['birth_date'] ?? '')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Genero</label>
            <input type="text" name="gender" value="<?= e(old('gender', $person['gender'] ?? '')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2">
        </div>
    </div>
    <div class="flex gap-3">
        <button class="px-4 py-2 rounded-xl bg-black text-white font-semibold">Salvar</button>
        <a href="<?= url('admin/pessoas') ?>" class="px-4 py-2 rounded-xl border border-gray-200">Cancelar</a>
    </div>
</form>
