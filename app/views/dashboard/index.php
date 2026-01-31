<h2 class="text-2xl font-semibold mb-2">Dashboard</h2>
<p class="text-sm text-gray-600 mb-6">Visao geral administrativa e pendencias de inscricao.</p>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <?php foreach ($stats as $stat): ?>
        <div class="rounded-2xl border border-amber-100 bg-amber-50/50 p-4">
            <div class="text-xs text-gray-500 uppercase tracking-wider"><?= e($stat['label']) ?></div>
            <div class="text-2xl font-semibold mt-2"><?= e($stat['value']) ?></div>
            <div class="text-xs text-gray-500 mt-2"><?= e($stat['hint']) ?></div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (!empty($actions)): ?>
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-3">Acoes rapidas</h3>
        <div class="flex flex-wrap gap-3">
            <?php foreach ($actions as $action): ?>
                <a href="<?= e($action['url']) ?>" class="px-4 py-2 rounded-full bg-black text-white text-sm font-semibold hover:opacity-90">
                    <?= e($action['label']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
