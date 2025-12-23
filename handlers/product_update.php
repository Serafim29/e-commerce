<?php


session_start();

require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../controllers/ProductController.php';

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

$existing = Product::getProductById($id, $pdo);
if (!$existing) {
    $_SESSION['error'] = 'Product not found.';
    header('Location: ../admin/products.php');
    exit;
}

$title         = sanitizeField($_POST['title'] ?? '');
$brand         = sanitizeField($_POST['brand'] ?? '');
$description   = sanitizeField($_POST['description'] ?? '');
$price         = $_POST['price'] ?? '';
$qty           = $_POST['qty'] ?? '';
$currentImage  = $_POST['current_image'] ?? '';
$newImageArray = $_FILES['image'] ?? [];

$dataForValidation = [
    'title'       => $title,
    'brand'       => $brand,
    'description' => $description,
    'price'       => $price,
    'qty'         => $qty,
];

$errors = validateProductData($dataForValidation);


$finalImage = $currentImage;

if (isset($newImageArray['error']) && $newImageArray['error'] === UPLOAD_ERR_OK) {
    $imageResult = handleProductImage($newImageArray, $title);
    if (is_array($imageResult)) {

        $errors = array_merge($errors, $imageResult);
    } else {
        $finalImage = $imageResult;

        if (!empty($currentImage)) {
            $oldPath = __DIR__ . '/../uploads/' . $currentImage;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
    }
}

if (!empty($errors)) {
    $_SESSION['error'] = implode(' ', $errors);
    header('Location: ../admin/product_edit.php?id=' . $id);
    exit;
}

$productData = [
    'title'       => $title,
    'image'       => $finalImage,
    'brand'       => $brand,
    'description' => $description,
    'price'       => $price,
    'qty'         => $qty,
];

try {
    $updated = Product::updateProduct($id, $productData, $pdo);
    if ($updated) {
        $_SESSION['success'] = 'Product updated successfully.';
    } else {
        $_SESSION['error'] = 'No changes were made to the product.';
    }
} catch (Throwable $e) {
    $_SESSION['error'] = 'Database error: ' . $e->getMessage();
}

header('Location: ../admin/product_edit.php?id=' . $id);
exit;


