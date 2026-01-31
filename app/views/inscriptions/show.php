<h2 class="text-2xl font-semibold mb-4">Inscricao #<?= e($inscription['id']) ?></h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="rounded-xl border border-gray-100 p-4">
        <div class="text-xs uppercase text-gray-500">Candidato</div>
        <div class="text-lg font-semibold mt-2"><?= e($inscription['full_name']) ?></div>
        <div class="text-sm text-gray-600 mt-1">Email: <?= e($inscription['email']) ?></div>
        <div class="text-sm text-gray-600">Telefone: <?= e($inscription['phone'] ?? '-') ?></div>
        <div class="text-sm text-gray-600">CPF: <?= e($inscription['cpf'] ?? '-') ?></div>
    </div>
    <div class="rounded-xl border border-gray-100 p-4">
        <div class="text-xs uppercase text-gray-500">Escolha</div>
        <div class="text-sm mt-2">Modulo: <strong><?= e($inscription['module_name'] ?? '-') ?></strong></div>
        <div class="text-sm">Polo: <strong><?= e($inscription['pole_name'] ?? '-') ?></strong></div>
        <div class="text-sm">Modalidade: <strong><?= e($inscription['modality_name'] ?? '-') ?></strong></div>
        <div class="text-sm mt-3">Status:
            <span class="px-2 py-1 rounded-full text-xs font-semibold
                <?= $inscription['status'] === 'pending' ? 'bg-amber-100 text-amber-800' : '' ?>
                <?= $inscription['status'] === 'approved' ? 'bg-emerald-100 text-emerald-800' : '' ?>
                <?= $inscription['status'] === 'rejected' ? 'bg-rose-100 text-rose-800' : '' ?>">
                <?= e($inscription['status']) ?>
            </span>
        </div>
    </div>
</div>

<?php if (!empty($inscription['review_notes'])): ?>
    <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm">
        <div class="font-semibold mb-1">Review registrado</div>
        <?= nl2br(e($inscription['review_notes'])) ?>
    </div>
<?php endif; ?>

<?php if (!empty($inscription['rejection_reason'])): ?>
    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm">
        <div class="font-semibold mb-1">Motivo da rejeicao</div>
        <?= nl2br(e($inscription['rejection_reason'])) ?>
    </div>
<?php endif; ?>

<?php if ($inscription['status'] === 'pending'): ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <?php if (RBAC::can('inscriptions.review')): ?>
            <form method="post" action="<?= url('admin/inscricoes/' . $inscription['id'] . '/review') ?>" class="rounded-xl border border-gray-100 p-4 space-y-3">
                <?= csrf_field() ?>
                <div class="text-sm font-semibold">Review</div>
                <textarea name="review_notes" rows="4" class="w-full rounded-xl border border-gray-200 px-3 py-2" placeholder="Observacoes para manter pendente"></textarea>
                <button class="w-full rounded-xl bg-amber-500 text-white py-2 font-semibold">Registrar review</button>
            </form>
        <?php endif; ?>

        <?php if (RBAC::can('inscriptions.approve')): ?>
            <form method="post" action="<?= url('admin/inscricoes/' . $inscription['id'] . '/approve') ?>" class="rounded-xl border border-emerald-100 p-4 space-y-3">
                <?= csrf_field() ?>
                <div class="text-sm font-semibold">Aprovar</div>
                <p class="text-xs text-gray-600">Cria Pessoa + Usuario (Aluno) + Matricula automaticamente.</p>
                <button class="w-full rounded-xl bg-emerald-600 text-white py-2 font-semibold">Aprovar inscricao</button>
            </form>
        <?php endif; ?>

        <?php if (RBAC::can('inscriptions.reject')): ?>
            <form method="post" action="<?= url('admin/inscricoes/' . $inscription['id'] . '/reject') ?>" class="rounded-xl border border-rose-100 p-4 space-y-3">
                <?= csrf_field() ?>
                <div class="text-sm font-semibold">Rejeitar</div>
                <textarea name="rejection_reason" rows="4" class="w-full rounded-xl border border-gray-200 px-3 py-2" placeholder="Justificativa obrigatoria"></textarea>
                <button class="w-full rounded-xl bg-rose-600 text-white py-2 font-semibold">Rejeitar</button>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>
