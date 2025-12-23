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

$products = Product::getAllProducts($pdo);

$success = $_SESSION['success'] ?? null;
$error   = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

$page_title = 'Products Admin';

include __DIR__ . '/includes/header.php';
?>

<?php if ($success): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center gap-3 transition-all duration-300">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center gap-3 transition-all duration-300">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden shadow-sm">
    <div class="flex items-center justify-between px-8 py-6 border-b border-zinc-200 bg-zinc-50">
        <div>
            <h2 class="text-2xl font-semibold text-zinc-900">All Products</h2>
            <p class="text-sm text-zinc-500 mt-1"><?= count($products) ?> products in inventory</p>
        </div>

        <a href="product_add.php"
        class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-md shadow-blue-600/20 transition-all">
            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-white/15 border border-white/30">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </span>
            <span>+ Add Product</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-zinc-200 text-sm">
            <thead class="bg-zinc-100">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-zinc-700 uppercase">Image</th>
                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-zinc-700 uppercase">Title</th>
                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-zinc-700 uppercase">Brand</th>
                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-zinc-700 uppercase">Price</th>
                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-zinc-700 uppercase">STOCK</th>
                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-zinc-700 uppercase">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100 bg-white">
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-4 text-sm text-zinc-400">
                        No products found. Click "Add Product" to create one.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr class="hover:bg-zinc-50 transition-colors">
                        <td class="px-6 py-3">
                            <?php if (!empty($product['image'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($product['image']) ?>"
                                    alt="<?= htmlspecialchars($product['title']) ?>"
                                    class="w-12 h-12 object-cover rounded border border-white/10">
                            <?php else: ?>
                                <span class="text-xs text-zinc-500">No image</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-3 text-sm font-semibold text-zinc-900">
                            <?= htmlspecialchars($product['title']) ?>
                        </td>
                        <td class="px-6 py-3 text-sm text-zinc-700">
                            <?= htmlspecialchars($product['brand']) ?>
                        </td>
                        <td class="px-6 py-3 text-sm font-semibold text-emerald-600">
                            $<?= htmlspecialchars($product['price']) ?>
                        </td>
                        <td class="px-6 py-3 text-sm text-zinc-700">
                            <?= htmlspecialchars($product['qty']) ?> units
                        </td>
                        <td class="px-6 py-3 text-sm text-zinc-300">
                            <div class="flex items-center gap-3">
                                <a href="product_edit.php?id=<?= htmlspecialchars((string)$product['id']) ?>"
                                class="text-xs px-3 py-1.5 rounded bg-blue-500/20 text-blue-300 border border-blue-500/40 hover:bg-blue-500/30">
                                    Edit
                                </a>
                                <form action="../handlers/product_delete.php" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$product['id']) ?>">
                                    <button type="submit"
                                            class="text-xs px-3 py-1.5 rounded bg-red-500/20 text-red-300 border border-red-500/40 hover:bg-red-500/30">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>