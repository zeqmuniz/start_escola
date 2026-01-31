<h2 class="text-2xl font-semibold mb-4">Minha conta</h2>
<div class="rounded-xl border border-gray-100 p-4 mb-6">
    <div class="text-xs uppercase text-gray-500">Dados</div>
    <div class="text-sm mt-2">Email: <strong><?= e($user['email']) ?></strong></div>
    <div class="text-sm">Status: <strong><?= e($user['status']) ?></strong></div>
</div>

<form method="post" action="<?= url('minha-conta/senha') ?>" class="space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium text-gray-700">Senha atual</label>
        <input type="password" name="current_password" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2" required>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nova senha</label>
            <input type="password" name="new_password" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Confirmar nova senha</label>
            <input type="password" name="confirm_password" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2" required>
        </div>
    </div>
    <button class="px-4 py-2 rounded-xl bg-black text-white font-semibold">Atualizar senha</button>
</form>
