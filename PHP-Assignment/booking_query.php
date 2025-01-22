<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["email"]) || $_SESSION["email"] === "admin@ikarrental.hu") {
    header("Location: login.php");
    exit;
}

$bookings = json_decode(file_get_contents("bookings.json"), true) ?? [];
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$carId = $_POST['carId'];
$userEmail = $_SESSION["email"];

$errors = [];

if (empty($startDate) || empty($endDate)) {
    $errors[] = "Both start and end dates are required.";
} elseif (strtotime($startDate) > strtotime($endDate)) {
    $errors[] = "Start date cannot be after the end date.";
}

foreach ($bookings as $booking) {
    if (
        $booking['carId'] == $carId &&
        (
            (strtotime($startDate) >= strtotime($booking['start_date']) && strtotime($startDate) <= strtotime($booking['end_date'])) ||
            (strtotime($endDate) >= strtotime($booking['start_date']) && strtotime($endDate) <= strtotime($booking['end_date']))
        )
    ) {
        $errors[] = "This car is already booked for the selected date range.";
        break;
    }
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: car_details.php?carId=" . urlencode($carId));
    exit;
} else {
    $bookings[] = [
        "carId" => $carId,
        "userEmail" => $userEmail,
        "start_date" => $startDate,
        "end_date" => $endDate
    ];
    file_put_contents("bookings.json", json_encode($bookings, JSON_PRETTY_PRINT));
    $_SESSION['success'] = "Booking successful!";
    header("Location: car_details.php?carId=" . urlencode($carId));
    exit;
}
