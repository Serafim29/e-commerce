<?php
session_start();
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Product.php';
 
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}
 
$user = User::getUserById($_SESSION['user_id'], $pdo);
 
if (!$user || !User::isAdmin($user)) {
    header('Location: ../public/profile.php');
    exit;
}
 
$totalProducts = Product::count($pdo);
$totalUsers = User::count($pdo);
$products = Product::getAllProducts($pdo);
$recentProducts = array_slice($products, 0, 5);
 
$page_title = 'Dashboard Admin';
?>
 
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
 
<body>
    <?php include 'includes/header.php'; ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="group relative bg-dark-800 rounded-2xl p-6 border border-blue-500/30 transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-3xl font-bold mb-1"><?= $totalProducts ?></p>
                <p class="text-sm text-zinc-500">Total Products</p>
            </div>
        </div>
 
        <div class="group relative bg-dark-800 rounded-2xl p-6 border border-emerald-500/30 transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold mb-1"><?= $totalUsers ?></p>
                <p class="text-sm text-zinc-500">Total Users</p>
            </div>
        </div>
 
        <div class="group relative bg-dark-800 rounded-2xl p-6 border border-amber-500/30 transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold mb-1">$<?= number_format(array_sum(array_column($products, 'price')), 0) ?></p>
                <p class="text-sm text-zinc-500">Inventory Value</p>
            </div>
        </div>
 
        <div class="group relative bg-dark-800 rounded-2xl p-6 border border-purple-500/30 transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold mb-1"><?= array_sum(array_column($products, 'qty')) ?></p>
                <p class="text-sm text-zinc-500">Stock Units</p>
            </div>
        </div>
    </div>
 
    <div class="bg-dark-800 rounded-2xl border border-white/5 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-white/5">
            <h2 class="text-lg font-semibold">Recent Products</h2>
            <a href="products.php" class="text-sm text-accent hover:text-accent-light transition-colors">View All →</a>
        </div>
 
        <?php if (empty($recentProducts)): ?>
            <div class="p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-dark-700 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">No products yet</h3>
                <p class="text-zinc-500 mb-6">Start by adding your first product to the inventory.</p>
                <a href="product_add.php" class="inline-flex items-center gap-2 px-5 py-2.5 bg-accent hover:bg-accent-dark text-white rounded-xl font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Product
                </a>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Product</th>
                            <th class="px-6 py-4">Brand</th>
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4">Stock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php foreach ($recentProducts as $product): ?>
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img src="<?= htmlspecialchars($product['image'] ?: 'https://via.placeholder.com/48') ?>"
                                            alt="<?= htmlspecialchars($product['title']) ?>"
                                            class="w-12 h-12 rounded-xl object-cover bg-dark-700">
                                        <div>
                                            <p class="font-medium"><?= htmlspecialchars($product['title']) ?></p>
                                            <p class="text-xs text-zinc-500">ID: <?= $product['id'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-zinc-400"><?= htmlspecialchars($product['brand'] ?: 'N/A') ?></td>
                                <td class="px-6 py-4">
                                    <span class="text-emerald-400 font-semibold">$<?= number_format($product['price'], 2) ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="<?= $product['qty'] < 10 ? 'text-red-400' : 'text-zinc-400' ?>">
                                        <?= $product['qty'] ?> units
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
    </div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
</body>
 
</html>