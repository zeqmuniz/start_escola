<h2 class="text-xl font-semibold mb-4">Entrar</h2>
<form method="post" action="<?= url('login') ?>" class="space-y-5 text-base sm:text-lg">
    <?= csrf_field() ?>
    <div>
        <label class="block font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="<?= e(old('email')) ?>" class="mt-1 w-3/4 mx-auto block rounded-xl border border-transparent bg-[#c2c2c2] px-4 py-3 text-base sm:text-lg focus:outline-none focus:ring-2 focus:ring-[#333333] focus:border-[#333333]" required>
    </div>
    <div>
        <label class="block font-medium text-gray-700">Senha</label>
        <input type="password" name="password" class="mt-1 w-3/4 mx-auto block rounded-xl border border-transparent bg-[#c2c2c2] px-4 py-3 text-base sm:text-lg focus:outline-none focus:ring-2 focus:ring-[#333333] focus:border-[#333333]" required>
    </div>
    <div class="flex items-center justify-center gap-4">
        <button class="w-2/5 rounded-xl bg-black text-white py-3 font-semibold hover:bg-gray-600">Entrar</button>
        <button type="reset" class="w-2/5 rounded-xl bg-black text-white py-3 font-semibold hover:bg-gray-600">Limpar</button>
    </div>
</form>
