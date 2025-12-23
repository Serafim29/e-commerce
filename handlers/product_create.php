<?php


session_start();

require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/products.php');
    exit;
}

$title       = sanitizeField($_POST['title'] ?? '');
$brand       = sanitizeField($_POST['brand'] ?? '');
$description = sanitizeField($_POST['description'] ?? '');
$price       = $_POST['price'] ?? '';
$qty         = $_POST['qty'] ?? '';
$image       = $_FILES['image'] ?? [];

$dataForValidation = [
    'title'       => $title,
    'brand'       => $brand,
    'description' => $description,
    'price'       => $price,
    'qty'         => $qty,
];

$errors = validateProductData($dataForValidation);

$imageResult = handleProductImage($image, $title);
$imageFile   = '';

if (is_array($imageResult)) {

    $errors = array_merge($errors, $imageResult);
} else {
    $imageFile = $imageResult; 
}

if (!empty($errors)) {
    $_SESSION['error'] = implode(' ', $errors);
    header('Location: ../admin/product_add.php');
    exit;
}

$productData = [
    'title'       => $title,
    'image'       => $imageFile,
    'brand'       => $brand,
    'description' => $description,
    'price'       => $price,
    'qty'         => $qty,
];

try {
    $created = Product::createProduct($productData, $pdo);

    if ($created) {
        $_SESSION['success'] = 'Product created successfully.';
    } else {
        $_SESSION['error'] = 'Failed to create product.';
    }
} catch (Throwable $e) {
    $_SESSION['error'] = 'Database error: ' . $e->getMessage();
}

header('Location: ../admin/products.php');
exit;


