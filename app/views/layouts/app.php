<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(config('app.name')) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sidebar: '#0b2f30',
                        sidebarLight: '#124948',
                        accent: '#d97706',
                    }
                }
            }
        };
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700&display=swap');
        body {
            font-family: 'Sora', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #fef3c7 60%, #ecfeff 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="antialiased text-slate-900">
    <?php $user = Auth::user(); ?>
    <?php $logoPath = base_path('public/assets/logo.png'); ?>
    <div class="min-h-screen flex flex-col">
        <header class="bg-black text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <?php if (file_exists($logoPath)): ?>
                        <img src="<?= url('assets/logo.png') ?>" alt="Logo" class="w-9 h-9 rounded-xl object-contain bg-white p-1">
                    <?php else: ?>
                        <div class="w-8 h-8 rounded-xl bg-white text-black flex items-center justify-center font-semibold">ST</div>
                    <?php endif; ?>
                    <span class="text-sm md:text-base font-semibold tracking-wide"><?= e(config('app.name')) ?></span>
                </div>
                <div class="flex items-center gap-4 text-xs md:text-sm">
                    <div class="text-white/80"><?= e($user['email'] ?? '') ?></div>
                    <a class="px-3 py-1 rounded-full border border-white/30 hover:border-white" href="<?= url('minha-conta') ?>">Minha conta</a>
                    <form method="post" action="<?= url('logout') ?>">
                        <?= csrf_field() ?>
                        <button class="px-3 py-1 rounded-full bg-white text-black font-semibold">Sair</button>
                    </form>
                </div>
            </div>
        </header>
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-1">
            <div class="flex flex-col md:flex-row gap-6 items-stretch w-full">
                <aside class="md:w-64 w-full rounded-2xl bg-sidebar text-white p-4 shadow-lg self-stretch h-full min-h-[calc(100vh-8rem)]">
                    <?php require base_path('app/views/partials/sidebar.php'); ?>
                </aside>
                <main class="flex-1 self-stretch w-full min-w-0">
                    <?php require base_path('app/views/partials/flash.php'); ?>
                    <div class="w-full bg-white/95 rounded-2xl shadow-lg border border-white/60 p-6 min-h-[calc(100vh-8rem)]">
                        <?= $content ?>
                    </div>
                </main>
            </div>
        </div>
        <footer class="bg-white/95 border-t border-white/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-slate-600">
                &copy; <?= date('Y') ?> Igreja do Centro. Start - Treinamento Ministerial.
            </div>
        </footer>
    </div>
</body>
</html>
