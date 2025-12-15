<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../database/db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}

$user = User::getUserById(id: $_SESSION['user_id'], pdo: $pdo);

if(!$user || !User::isAdmin(user: $user)) {
    header('Location: ../public/profile.php');
    exit;
}

$page_title = 'Users Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
   <?php include 'includes/header.php'; ?>
   <?php include 'includes/footer.php'; ?>
</body>
</html>