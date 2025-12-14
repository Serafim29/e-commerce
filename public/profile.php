<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../database/db.php';
session_start();
$user = User::getUserById($_SESSION['user_id'], $pdo);
if (!$user) {
    header('Location: ../public/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h2>Profile</h2>
    <p>Welcome, <?php echo $user['username']; ?></p>
    <p>Email: <?php echo $user['email']; ?></p>
    <a href="../handlers/handle_logout.php">Logout</a>
</body>
</html>