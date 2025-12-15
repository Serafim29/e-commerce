<?php
session_start();
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../database/db.php';

$errors = AuthController::validateRegister($_POST);

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header(header: 'Location: ../public/register.php');
    exit;
}

$userExists = User::getUserByEmail($_POST['email'], $pdo);

if ($userExists) {
    $_SESSION['errors'] = ["User with this email already exists."];
    header(header: 'Location: ../public/register.php');
    exit;
}

User::createUser($_POST['username'], $_POST['email'], $_POST['password'], $pdo);

header(header: 'Location: ../public/login.php');
exit;