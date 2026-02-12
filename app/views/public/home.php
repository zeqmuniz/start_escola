<div class="space-y-0">
    <div class="overflow-hidden bg-[#1f1f1f]">
        <div class="home-parallax w-full h-96 sm:h-[32rem] md:h-[40rem]"></div>
    </div>

    <div class="bg-transparent home-parallax p-6 md:p-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl sm:text-3xl font-semibold text-white">Escola Start - Treinamento Ministerial</h2>
            <p class="mt-2 text-base sm:text-lg text-white">venha estudar conosco as Sagradas Escrituras</p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 md:p-8">
            <div class="mb-6 text-center">
                <h5 class="text-xl font-semibold text-[#0b2f30]">Fa&#231;a a Sua Inscri&#231;&#227;o! Escolha o M&#243;dulo!</h5>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($modules as $module): ?>
                    <?php $imagePath = base_path('public/assets/modules/module-' . $module['id'] . '.png'); ?>
                    <a href="<?= url('inscricao?module_id=' . $module['id']) ?>" class="rounded-3xl border border-slate-200 bg-white p-4 md:p-5 flex flex-col module-card" aria-label="Inscrever no modulo">
                        <?php if (file_exists($imagePath)): ?>
                            <div class="overflow-hidden rounded-2xl">
                                <img src="<?= url('assets/modules/module-' . $module['id'] . '.png') ?>" alt="" class="w-full h-44 object-cover module-image">
                            </div>
                        <?php else: ?>
                            <div class="w-full h-44 rounded-2xl bg-slate-100"></div>
                        <?php endif; ?>
                        <span class="sr-only"><?= e($module['name']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

