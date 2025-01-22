<?php
include("storage.php");
$carsStorage = new Storage(new JsonIO("cars.json"));

$carId = $_GET["carId"];

$car = $carsStorage->findOne(["id" => (int)$carId]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/7a2e7b22c5.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include_once "navigate.php" ?>
    <div class="flex flex-wrap justify-center">
        <div class="card lg:card-side bg-base-100 shadow-xl w-2/3">
            <figure>
                <img src="<?= $car["image"] ?>" alt="Car Image" />
            </figure>
            <div class="card-body">
                <h2 class="card-title"><?= $car["brand"] ?> <?= $car['model'] ?></h2>
                <p>Fuel: <?= $car["fuel_type"] ?></p>
                <p>Shifter: <?= $car["transmission"] ?></p>
                <p>Year of manufacture: <?= $car["year"] ?></p>
                <p>Number of seats: <?= $car["passengers"] ?></p>
                <p>Price per day: <?= number_format($car["daily_price_huf"]) ?> HUF</p>

                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="alert alert-error">
                        <ul>
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'] ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <form action="booking_query.php" method="POST" class="mt-4">
                    <input type="hidden" name="carId" value="<?= $carId ?>">
                    <div class="form-control mb-4">
                        <label for="start_date" class="label">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="input input-bordered w-full" required>
                    </div>
                    <div class="form-control mb-4">
                        <label for="end_date" class="label">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="input input-bordered w-full" required>
                    </div>
                    <div class="card-actions justify-end">
                        <button type="submit" class="btn btn-primary rounded-xxl">Book it</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>