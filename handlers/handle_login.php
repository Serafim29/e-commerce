<?php
session_start();
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../database/db.php';

$errors = AuthController::validateLogin($_POST);

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header(header: 'Location: ../public/login.php');
    exit;
}

$user = User::getUserByEmail($_POST['email'], $pdo);

if (!$user || !password_verify($_POST['password'], $user['password'])) {
    $_SESSION['errors'] = ["Invalid email or password."];
    header(header: 'Location: ../public/login.php');
    exit;
}

$_SESSION['user_id'] = $user['id'];

if(User::isAdmin(user: $user)) {
    header(header: 'Location: ../admin/dashboard.php');
    exit;
}else {
    header(header: 'Location: ../public/profile.php');
}
exit;