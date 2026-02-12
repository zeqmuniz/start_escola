<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(config('app.name')) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= url('assets/guest.css') ?>?v=<?= filemtime(base_path('public/assets/guest.css')) ?>">
</head>
<?php
$logoPath = base_path('public/assets/logo.png');
$pageWide = $pageWide ?? false;
$formWide = $formWide ?? false;
$loginPage = $loginPage ?? false;
?>
<body class="antialiased <?= $loginPage ? 'login-bg' : '' ?>">
    <div class="min-h-screen flex flex-col">
        <?php if ($pageWide): ?>
            <header class="w-full bg-[#ec0000]">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-14 sm:h-16 flex items-center justify-between">
                    <div class="flex items-center gap-3 text-white">
                        <?php if (file_exists($logoPath)): ?>
                            <img src="<?= url('assets/logo.png') ?>" alt="Logo" class="w-16 h-12 sm:w-20 sm:h-14 rounded-lg object-contain bg-[#ec0000] px-2 py-1">
                        <?php else: ?>
                            <div class="w-16 h-12 sm:w-20 sm:h-14 rounded-lg bg-[#ec0000] text-white flex items-center justify-center font-bold">ST</div>
                        <?php endif; ?>
                        <span class="text-base sm:text-lg font-semibold">Start - Treinamento Ministerial</span>
                    </div>
                    <a href="<?= url('login') ?>" class="text-base sm:text-lg font-semibold text-white hover:opacity-90">Entrar</a>
                </div>
            </header>
        <?php else: ?>
            <header class="w-full bg-[#ec0000]">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-14 sm:h-16 flex items-center justify-between">
                    <div class="flex items-center gap-3 text-white">
                        <?php if (file_exists($logoPath)): ?>
                            <img src="<?= url('assets/logo.png') ?>" alt="Logo" class="w-16 h-12 sm:w-20 sm:h-14 rounded-lg object-contain bg-[#ec0000] px-2 py-1">
                        <?php else: ?>
                            <div class="w-16 h-12 sm:w-20 sm:h-14 rounded-lg bg-[#ec0000] text-white flex items-center justify-center font-bold">ST</div>
                        <?php endif; ?>
                        <span class="text-base sm:text-lg font-semibold">Start - Treinamento Ministerial</span>
                    </div>
                    <nav class="text-sm sm:text-base text-white" aria-label="Breadcrumb">
                        <ol class="flex items-center gap-2">
                            <li>
                                <a href="<?= url('') ?>" class="font-semibold hover:opacity-90 inline-flex items-center" aria-label="Home">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path d="M11.47 3.31a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 0 1-1.06 1.06L18 10.86V19.5a.75.75 0 0 1-.75.75h-4.5a.75.75 0 0 1-.75-.75V15a.75.75 0 0 0-.75-.75h-1.5A.75.75 0 0 0 9 15v4.5a.75.75 0 0 1-.75.75h-4.5A.75.75 0 0 1 3 19.5v-8.64l-.97 1.01a.75.75 0 0 1-1.06-1.06l7.5-7.5Z"/>
                                    </svg>
                                    <span class="sr-only">Home</span>
                                </a>
                            </li>
                            <li class="text-white/70">/</li>
                            <li class="text-white/90">Login</li>
                        </ol>
                    </nav>
                </div>
            </header>
        <?php endif; ?>
        <div class="flex-1 flex items-start justify-center px-4 <?= $pageWide ? 'pt-0 pb-10' : 'py-10' ?>">
            <div class="w-full <?= $pageWide ? 'max-w-7xl' : ($formWide ? 'max-w-[700px]' : 'max-w-xl') ?>">
                <?php if (!$pageWide): ?>
                    <div class="mb-6 text-center">
                        <?php if (file_exists($logoPath)): ?>
                            <img src="<?= url('assets/logo.png') ?>" alt="Logo" class="mx-auto w-4/5 h-auto object-contain">
                        <?php else: ?>
                            <div class="w-4/5 h-24 bg-black text-white font-bold flex items-center justify-center mx-auto">ST</div>
                        <?php endif; ?>
                    </div>
                    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 border border-slate-200">
                        <?php require base_path('app/views/partials/flash.php'); ?>
                        <?= $content ?>
                    </div>
                <?php else: ?>
                    <?php require base_path('app/views/partials/flash.php'); ?>
                    <?= $content ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($pageWide): ?>
            <footer class="bg-[#6d6d6d]">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-white">
                    <div>Escola Start© 2026 por Igreja do Centro.</div>
                    <div class="mt-2">Contato WhatsApp: 12-99665-9390</div>
                </div>
            </footer>
        <?php else: ?>
            <footer class="bg-white border-t border-slate-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-slate-500 text-center">
                    &copy; <?= date('Y') ?> Igreja do Centro. Start - Treinamento Ministerial.
                </div>
            </footer>
        <?php endif; ?>
    </div>
</body>
</html>
