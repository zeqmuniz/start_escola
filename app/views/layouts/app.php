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
                        sidebar: '#0f3d3e',
                        sidebarLight: '#145c5b',
                        accent: '#f59e0b',
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
    <div class="min-h-screen">
        <header class="bg-black text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-white text-black flex items-center justify-center font-semibold">ST</div>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row gap-6">
                <aside class="md:w-64 w-full rounded-2xl bg-sidebar text-white p-4 shadow-lg">
                    <?php require base_path('app/views/partials/sidebar.php'); ?>
                </aside>
                <main class="flex-1">
                    <?php require base_path('app/views/partials/flash.php'); ?>
                    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-lg border border-white/60 p-6">
                        <?= $content ?>
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>
