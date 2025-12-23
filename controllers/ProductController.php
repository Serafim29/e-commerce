<?php

declare(strict_types=1);


function sanitizeField(string $value): string
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}


function validateProductData(array $data): array
{
    $errors = [];

    if (empty($data['title'])) {
        $errors[] = 'Product title is required.';
    }

    if (empty($data['brand'])) {
        $errors[] = 'Brand is required.';
    }

    if (empty($data['description'])) {
        $errors[] = 'Description is required.';
    }

    if ($data['price'] === '' || !is_numeric($data['price']) || $data['price'] < 0) {
        $errors[] = 'Price must be a positive number.';
    }

    if ($data['qty'] === '' || !ctype_digit((string)$data['qty']) || (int)$data['qty'] < 0) {
        $errors[] = 'Quantity must be a non-negative integer.';
    }

    return $errors;
}


function handleProductImage(array $image, string $title): array|string
{
    $errors = [];

    if (($image['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return '';
    }

    if (($image['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
        $tmpName      = $image['tmp_name'];
        $originalName = $image['name'];
        $ext          = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedExts  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $allowedExts, true)) {

            $sanitisedTitle = preg_replace('/[^a-zA-Z0-9]/', '_', $title);
            $newName        = $sanitisedTitle . '_' . uniqid() . '.' . $ext;
            $destination    = __DIR__ . '/../uploads/' . $newName;

            $uploadsDir = dirname($destination);
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }

            if (move_uploaded_file($tmpName, $destination)) {
                return $newName;
            }

            $errors[] = 'Failed to move uploaded file.';
        } else {
            $errors[] = 'Invalid image format. Allowed: JPG, JPEG, PNG, GIF, WEBP.';
        }
    } else {
        $errors[] = 'Failed to upload image. Error code: ' . $image['error'];
    }

    return $errors;
}


