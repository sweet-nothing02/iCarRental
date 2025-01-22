<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$users = json_decode(file_get_contents("users.json"), true);
$errors = [];

if (!isset($_POST['email'])) {
    $errors['email'] = "Email can't be empty";
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Invalid email format";
} elseif (array_search($_POST['email'], array_column($users, 'email')) !== false) {
    $errors['email'] = "Email is already registered";
} else {
    $email = $_POST['email'];
}

if (!isset($_POST['name']) || trim($_POST['name']) === "") {
    $errors['name'] = "Name is required";
} else {
    $name = $_POST['name'];
}

if (!isset($_POST['password'])) {
    $errors['password'] = "Password is required";
} elseif (strlen($_POST['password']) < 8) {
    $errors['password'] = "Password has to be at least 8 characters";
} elseif ($_POST['password'] !== $_POST['passwordConfirm']) {
    $errors['passwordConfirm'] = "Passwords do not match";
} else {
    $password = $_POST['password'];
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $_POST;
    header("Location: registration.php");
    exit();
}

$new_user = [
    "email" => $email,
    "name" => $name,
    "password" => $password
];

$users[] = $new_user;

file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));

header("Location: login.php");
exit();
