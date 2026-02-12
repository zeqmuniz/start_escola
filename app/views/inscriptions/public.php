<h2 class="text-xl font-semibold mb-4">Inscricao</h2>
<p class="text-sm text-gray-600 mb-6">Preencha seus dados para solicitar uma vaga. Esta inscricao nao cria usuario nem matricula.</p>
<form method="post" action="<?= url('inscricao') ?>" class="space-y-4">
    <?= csrf_field() ?>
    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nome completo</label>
        <input type="text" name="full_name" value="<?= e(old('full_name')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 focus:ring-2 focus:ring-amber-400" required>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">CPF</label>
            <input type="text" name="cpf" value="<?= e(old('cpf')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 focus:ring-2 focus:ring-amber-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Telefone</label>
            <input type="text" name="phone" value="<?= e(old('phone')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 focus:ring-2 focus:ring-amber-400">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="<?= e(old('email')) ?>" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 focus:ring-2 focus:ring-amber-400" required>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Modulo</label>
            <?php if (!empty($lockedModule)): ?>
                <input type="text" value="<?= e($lockedModule['name']) ?>" class="mt-1 w-full rounded-xl border border-gray-200 bg-slate-100 px-3 py-2" readonly>
                <input type="hidden" name="module_id" value="<?= e($lockedModule['id']) ?>">
            <?php else: ?>
                <select name="module_id" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 focus:ring-2 focus:ring-amber-400">
                    <option value="">Selecione</option>
                    <?php foreach ($modules as $module): ?>
                        <option value="<?= e($module['id']) ?>" <?= old('module_id') == $module['id'] ? 'selected' : '' ?>><?= e($module['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Polo</label>
            <select name="pole_id" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 focus:ring-2 focus:ring-amber-400">
                <option value="">Selecione</option>
                <?php foreach ($poles as $pole): ?>
                    <option value="<?= e($pole['id']) ?>" <?= old('pole_id') == $pole['id'] ? 'selected' : '' ?>><?= e($pole['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Modalidade</label>
            <select name="modality_id" class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 focus:ring-2 focus:ring-amber-400">
                <option value="">Selecione</option>
                <?php foreach ($modalities as $modality): ?>
                    <option value="<?= e($modality['id']) ?>" <?= old('modality_id') == $modality['id'] ? 'selected' : '' ?>><?= e($modality['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button class="w-full rounded-xl bg-black text-white py-2 font-semibold hover:opacity-90">Enviar inscricao</button>
</form>
