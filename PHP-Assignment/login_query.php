<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("storage.php");
$usersStorage = new Storage(new JsonIO("users.json"));

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: login.php");
        exit();
    }

    $user = $usersStorage->findOne(["email" => $email]);

    if (!$user || $_POST['password'] !== $user['password']) {
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: login.php");
        exit();
    }

    $_SESSION['email'] = $user['email'];
    $_SESSION['name'] = $user['name'];

    if ($user['email'] === "admin@ikarrental.hu") {
        header("Location: admin_page.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

header("Location: login.php");
exit();
