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


$success = $_SESSION['success'] ?? null;
$error   = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

$page_title = 'Add Product';

include __DIR__ . '/includes/header.php';
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Add Product</h1>
        <p class="text-white/60">Create a new product and upload an image.</p>
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


<form action="../handlers/product_create.php" method="POST" enctype="multipart/form-data" class="space-y-4 max-w-xl">
    <div>
        <label class="block text-sm font-medium mb-1" for="title">Title</label>
        <input type="text" id="title" name="title" required
            class="w-full px-3 py-2 rounded bg-[#616161]  border border-white/10 text-white">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1" for="brand">Brand</label>
        <input type="text" id="brand" name="brand" required
            class="w-full px-3 py-2 rounded bg-[#616161] border border-white/10 text-white">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1" for="description">Description</label>
        <textarea id="description" name="description" rows="4" required
                class="w-full px-3 py-2 rounded bg-[#616161] border border-white/10 text-white"></textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1" for="price">Price</label>
            <input type="number" step="0.01" id="price" name="price" required
                class="w-full px-3 py-2 rounded bg-[#616161] border border-white/10 text-white">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="qty">Quantity</label>
            <input type="number" id="qty" name="qty" required
                class="w-full px-3 py-2 rounded bg-[#616161] border border-white/10 text-white">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1" for="image">Product Image</label>

        <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif,.webp"
            class="w-full text-sm text-black">
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="px-5 py-2.5 bg-accent bg-[#616161]  text-white rounded-xl font-medium transition-colors">
            Save Product
        </button>
        <a href="products.php" class="text-sm text-zinc-400 hover:text-black">Back to products</a>
    </div>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>


