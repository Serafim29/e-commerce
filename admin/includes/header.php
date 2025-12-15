<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="flex min-h-screen">
        <?php include __DIR__ . '/sidebar.php'; ?>
    
        <main class="flex-1 ml-8">
            <header>
                <div class="flex items-center justify-between h-16 px-8">
                    <div>
                        <h1 class="text-xl font-semibold tracking-tight">
                            <?= htmlspecialchars($page_title ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?>
                        </h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-zinc-500"><?= date('l, M j, Y') ?></span>
                        <div class="w-px h-6 bg-white/10"></div>
                        <div class="flex items-center gap-3">
                            <?php if (isset($user['username'])): ?>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-accent to-purple-600 flex items-center justify-center text-sm font-semibold text-white">
                                    <?= htmlspecialchars(strtoupper(substr($user['username'], 0, 1)), ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </header>
            <div class="p-2">