<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(config('app.name')) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700&display=swap');
        :root {
            --ink: #111827;
            --accent: #f59e0b;
            --muted: #6b7280;
            --panel: #ffffff;
        }
        body {
            font-family: 'Sora', sans-serif;
            color: var(--ink);
            background: radial-gradient(circle at top left, #fef3c7 0%, #fef9f0 35%, #ecfeff 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-xl">
            <div class="mb-6 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-black text-white font-bold">ST</div>
                <h1 class="mt-4 text-2xl font-semibold"><?= e(config('app.name')) ?></h1>
                <p class="text-sm text-gray-600">Acesso seguro e organizado para os polos e secretaria.</p>
            </div>
            <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl p-6 md:p-8 border border-amber-100">
                <?php require base_path('app/views/partials/flash.php'); ?>
                <?= $content ?>
            </div>
            <p class="mt-6 text-center text-xs text-gray-500">&copy; <?= date('Y') ?> Igreja do Centro</p>
        </div>
    </div>
</body>
</html>
