<h2 class="text-xl font-semibold mb-4">Entrar</h2>
<form method="post" action="<?= url('login') ?>" class="space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="<?= e(old('email')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Senha</label>
        <input type="password" name="password" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400" required>
    </div>
    <button class="w-full rounded-xl bg-black text-white py-2 font-semibold hover:opacity-90">Entrar</button>
</form>
<div class="mt-6 text-sm text-gray-600">
    <a href="<?= url('inscricao') ?>" class="text-amber-700 font-semibold">Quero me inscrever</a>
</div>
