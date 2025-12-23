<?php


session_start();

require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../models/Product.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/products.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    $_SESSION['error'] = 'Invalid product ID.';
    header('Location: ../admin/products.php');
    exit;
}

$product = Product::getProductById($id, $pdo);

if ($product && !empty($product['image'])) {
    $imagePath = __DIR__ . '/../uploads/' . $product['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

try {
    $deleted = Product::deleteProduct($id, $pdo);
    if ($deleted) {
        $_SESSION['success'] = 'Product deleted successfully.';
    } else {
        $_SESSION['error'] = 'Failed to delete product.';
    }
} catch (Throwable $e) {
    $_SESSION['error'] = 'Database error: ' . $e->getMessage();
}

header('Location: ../admin/products.php');
exit;


