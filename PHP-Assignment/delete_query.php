<?php
session_start();

if ($_SESSION["email"] !== "admin@ikarrental.hu") {
    header("Location: admin_page.php");
    exit();
}

if (!isset($_GET['carId'])) {
    header("Location: admin_page.php?error=missing_car_id");
    exit();
}

$carId = (int) $_GET['carId'];

$cars = json_decode(file_get_contents("cars.json"), true) ?? [];

$cars = array_filter($cars, function ($car) use ($carId) {
    return $car['id'] !== $carId;
});

file_put_contents("cars.json", json_encode(array_values($cars), JSON_PRETTY_PRINT));

header("Location: admin_page.php?success=car_deleted");
exit();
