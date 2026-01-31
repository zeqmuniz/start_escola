<?php
$success = flash('success');
$error = flash('error');
$warning = flash('warning');
?>
<?php if ($success): ?>
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-900 px-4 py-3 text-sm">
        <?= e($success) ?>
    </div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-900 px-4 py-3 text-sm">
        <?= e($error) ?>
    </div>
<?php endif; ?>
<?php if ($warning): ?>
    <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 text-amber-900 px-4 py-3 text-sm">
        <?= e($warning) ?>
    </div>
<?php endif; ?>
