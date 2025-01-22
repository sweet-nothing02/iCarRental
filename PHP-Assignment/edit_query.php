<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION["email"] !== "admin@ikarrental.hu") {
    header("Location: login.php");
    exit;
}

$cars = json_decode(file_get_contents("cars.json"), true) ?? [];

$errors = [];
$data = [
    'id' => (int)($_POST['id'] ?? '-1'),
    'brand' => trim($_POST['brand'] ?? ''),
    'model' => trim($_POST['model'] ?? ''),
    'fuel_type' => trim($_POST['fuel_type'] ?? ''),
    'transmission' => trim($_POST['transmission'] ?? ''),
    'year' => $_POST['year'] ?? '',
    'passengers' => $_POST['passengers'] ?? '',
    'daily_price_huf' => $_POST['daily_price_huf'] ?? '',
    'image' => trim($_POST['image'] ?? 'https://adaptcommunitynetwork.org/wp-content/uploads/2022/01/ef3-placeholder-image-768x518.jpg'),
];

if (empty($data['brand'])) {
    $errors['brand'] = "Brand is required.";
}
if (empty($data['model'])) {
    $errors['model'] = "Model is required.";
}
if (empty($data['fuel_type'])) {
    $errors['fuel_type'] = "Fuel type is required.";
}
if (empty($data['transmission'])) {
    $errors['transmission'] = "Transmission is required.";
}
if (empty($data['year']) || !is_numeric($data['year']) || (int)$data['year'] < 1886 || (int)$data['year'] > date("Y")) {
    $errors['year'] = "Year must be a valid number between 1886 and " . date("Y") . ".";
}
if (empty($data['passengers']) || !is_numeric($data['passengers']) || (int)$data['passengers'] <= 0) {
    $errors['passengers'] = "Number of seats must be a positive integer.";
}
if (empty($data['daily_price_huf']) || !is_numeric($data['daily_price_huf']) || (int)$data['daily_price_huf'] <= 0) {
    $errors['daily_price_huf'] = "Price must be a positive number.";
}
if (empty($data['image']) || !filter_var($data['image'], FILTER_VALIDATE_URL)) {
    $errors['image'] = "Image must be a valid URL.";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $data;
    header("Location: edit.php?carId=" . urlencode($data['id']));
    exit;
}

if ($_POST['isNew'] === "true") {
    $allIds = array_map(fn($car) => $car['id'], $cars);
    $maxId = $allIds ? max($allIds) : 0;
    $data['id'] = $maxId + 1;

    $cars[] = $data;
} else {
    foreach ($cars as &$car) {
        if ($car['id'] === $data['id']) {
            $car = $data;
            break;
        }
    }
}

file_put_contents("cars.json", json_encode($cars, JSON_PRETTY_PRINT));

header("Location: admin_page.php");
exit;
