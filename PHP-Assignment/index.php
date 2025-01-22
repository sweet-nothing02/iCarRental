<?php
include("storage.php");
$carsStorage = new Storage(new JsonIO("cars.json"));

$filteredCars = $carsStorage->findAll();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $seats = (int)($_POST["seats"] ?? 0);
    $transmission = $_POST["transmission"] ?? null;
    $minPrice = (int)($_POST["min_price"] ?? 0);
    $maxPrice = (int)($_POST["max_price"] ?? PHP_INT_MAX);

    $filteredCars = $carsStorage->findMany(function ($car) use ($seats, $transmission, $minPrice, $maxPrice) {
        return ($seats === 0 || $car["passengers"] == $seats) &&
            ($transmission === null || strtolower($car["transmission"]) === strtolower($transmission)) &&
            ($car["daily_price_huf"] >= $minPrice && $car["daily_price_huf"] <= $maxPrice);
    });
}

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
    <form method="POST" class="p-4">
        <div class="flex gap-4">
            <div>
                <label for="seats" class="block font-medium">Seats</label>
                <input type="number" name="seats" id="seats" min="1" value="1" class="input input-bordered w-full" />
            </div>

            <div>
                <label for="type" class="block font-medium">Type</label>
                <select name="type" id="type" class="select select-bordered w-full">
                    <option value="">Any</option>
                    <option value="automatic">Automatic</option>
                    <option value="manual">Manual</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Price Range (HUF)</label>
                <input type="number" name="min_price" placeholder="Min" class="input input-bordered w-full" />
                <input type="number" name="max_price" placeholder="Max" class="input input-bordered w-full mt-2" />
            </div>

            <div class="flex items-end">
                <button type="submit" class="btn btn-primary w-full">Filter</button>
            </div>
        </div>
    </form>
    <div class="flex flex-wrap gap-3 justify-center">
        <?php foreach ($filteredCars as $car): ?>
            <div class="card card-compact bg-base-100 hover:bg-blue-60 w-72 shadow-xl relative">
                <figure class="relative">
                    <img src="<?= $car['image'] ?>" alt="<?= $car['brand'] ?>" class="w-full h-48 object-cover">
                    <div class="absolute bottom-2 left-2 bg-black text-white px-2 py-1 text-sm rounded">
                        <?= number_format($car['daily_price_huf'], 0, '', '.') ?> HUF/day
                    </div>
                </figure>
                <div class="card-body">
                    <h2 class="card-title"><?= $car['brand'] ?></h2>
                    <div class="grid grid-cols-10 grid-rows-2 grid-flow-col gap-4 card-actions justify-end">
                        <p class="row-span-1 col-span-6"><?= $car['model'] ?></p>
                        <p class="row-span-1 col-span-6">
                            <?= $car['passengers'] ?> seats - <?= $car['transmission'] ?>
                        </p>
                        <a href="car_details.php?carId=<?= $car['id'] ?>" class="row-span-2 col-span-4 btn btn-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</body>

</html>