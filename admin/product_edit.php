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

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    $_SESSION['error'] = 'Invalid product ID.';
    header('Location: products.php');
    exit;
}

$product = Product::getProductById($id, $pdo);
if (!$product) {
    $_SESSION['error'] = 'Product not found.';
    header('Location: products.php');
    exit;
}

$success = $_SESSION['success'] ?? null;
$error   = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

$page_title = 'Edit Product';

include __DIR__ . '/includes/header.php';
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Edit Product</h1>
        <p class="text-black">Update product information and optionally change the image.</p>
    </div>
</div>

<?php if ($success): ?>
    <div class="mb-4 p-3 rounded bg-emerald-500/10 border border-emerald-500/40 text-emerald-300">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="mb-4 p-3 rounded bg-red-500/10 border border-red-500/40 text-red-300">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>


<form action="../handlers/product_update.php" method="POST" enctype="multipart/form-data" class="space-y-4 max-w-xl">
    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$product['id']) ?>">
    <input type="hidden" name="current_image" value="<?= htmlspecialchars($product['image'] ?? '') ?>">

    <div>
        <label class="block text-sm font-medium mb-1" for="title">Title</label>
        <input type="text" id="title" name="title" required
            value="<?= htmlspecialchars($product['title']) ?>"
            class="w-full px-3 py-2 rounded bg-[#616161] border border-white/10 text-white">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1" for="brand">Brand</label>
        <input type="text" id="brand" name="brand" required
            value="<?= htmlspecialchars($product['brand']) ?>"
            class="w-full px-3 py-2 rounded bg-[#616161] border border-white/10 text-white">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1" for="description">Description</label>
        <textarea id="description" name="description" rows="4" required
                class="w-full px-3 py-2 rounded bg-[#616161] border border-white/10 text-white"><?= htmlspecialchars($product['description']) ?></textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1" for="price">Price</label>
            <input type="number" step="0.01" id="price" name="price" required
                value="<?= htmlspecialchars($product['price']) ?>"
                class="w-full px-3 py-2 rounded bg-[#616161] border border-white/10 text-white">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="qty">Quantity</label>
            <input type="number" id="qty" name="qty" required
                value="<?= htmlspecialchars($product['qty']) ?>"
                class="w-full px-3 py-2 rounded bg-[#616161] border border-white/10 text-white">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Current Image</label>
        <?php if (!empty($product['image'])): ?>
            <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" alt="Product image"
                class="w-32 h-32 object-cover rounded mb-2 border border-white/10">
        <?php else: ?>
            <p class="text-sm text-zinc-500 mb-2">No image uploaded yet.</p>
        <?php endif; ?>

        <label class="block text-sm font-medium mb-1" for="image">Change Image (optional)</label>
        <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif,.webp"
            class="w-full text-sm text-black">
        <p class="mt-1 text-xs text-zinc-500">
            Leave this empty if you want to keep the current image.
        </p>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="px-5 py-2.5 bg-accent hover:bg-accent-dark text-black rounded-xl font-medium transition-colors">
            Save Changes
        </button>
        <a href="products.php" class="text-sm text-zinc-400 hover:text-black">Back to products</a>
    </div>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>


