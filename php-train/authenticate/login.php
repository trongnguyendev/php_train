<?php

if (!empty($_SESSION['user_info'])) {
    header("Location: /dashboard/index.php");
    exit;
}

$errors = $_SESSION['errors'] ?? [];
$oldInput = $_SESSION['old_input'] ?? ['username' => '', 'password' => ''];

unset($_SESSION['errors'], $_SESSION['old_input']);

function oldinput(string $field, array $oldInput): string {
    return htmlspecialchars($oldInput[$field] ?? '', ENT_QUOTES, 'UTF-8');
}

function displayError(string $field, array $errors): void {
    if (!empty($errors[$field])) {
        echo "<p class='error'>" . htmlspecialchars($errors[$field], ENT_QUOTES, 'UTF-8') . "</p>";
    }
}

require_once('../views/login/login.php');