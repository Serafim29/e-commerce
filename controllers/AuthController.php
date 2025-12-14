<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {

    public static function validateRegister($data) {
        $errors = [];

        if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $data['username']))
            $errors[] = "Username must be 3-20 chars (letters/numbers/underscore).";

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            $errors[] = "Invalid email.";

        if (strlen($data['password']) < 5)
            $errors[] = "Password must be at least 5 characters.";

        return $errors;
    }

    public static function validateLogin($data) {
        $errors = [];

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            $errors[] = "Invalid email.";

        if (strlen($data['password']) < 5)
            $errors[] = "Password too short.";

        return $errors;
    }
}