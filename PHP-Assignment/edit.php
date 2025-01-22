<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$accessDenied = $_SESSION["email"] !== "admin@ikarrental.hu";
if ($accessDenied) {
    header("Location: login.php");
    exit;
}

include("storage.php");
$carsStorage = new Storage(new JsonIO("cars.json"));

$carId = $_GET["carId"];
$car = $carsStorage->findOne(["id" => (int)$carId]);
$newId = -1;

if ($carId === "new") {
    $allIds = array_map(fn($car) => (int)$car['id'], $carsStorage->findAll());
    $maxId = $allIds ? max($allIds) : 0;
    $newId = $maxId + 1;
    var_dump($newId);
}

$errors = $_SESSION['errors'] ?? [];
$data = $_SESSION['data'] ?? [];

unset($_SESSION['errors']);
unset($_SESSION['data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css" rel="stylesheet" />
</head>

<body>
    <?php include_once "navigate.php"; ?>

    <div class="flex flex-wrap justify-center">
        <?php if ($carId === "new"): ?>
            <form method="POST" action="edit_query.php" class="card lg:card-side bg-base-100 shadow-xl w-2/3">
                <figure>
                    <img
                        src="https://adaptcommunitynetwork.org/wp-content/uploads/2022/01/ef3-placeholder-image-768x518.jpg"
                        alt="Car Image" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title">
                        Brand:
                        <input type="text" name="brand" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['brand'] ?? $car['brand'] ?? '' ?>" />
                        <?php if (isset($errors['brand'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['brand'] ?></span>
                        <?php endif; ?>
                    </h2>
                    <p>
                        Model:
                        <input type="text" name="model" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['model'] ?? $car['model'] ?? '' ?>" />
                        <?php if (isset($errors['model'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['model'] ?></span>
                        <?php endif; ?>
                    </p>
                    <p>
                        Fuel:
                        <input type="text" name="fuel_type" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['fuel_type'] ?? $car['fuel_type'] ?? '' ?>" />
                        <?php if (isset($errors['fuel_type'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['fuel_type'] ?></span>
                        <?php endif; ?>
                    </p>
                    <p>
                        Shifter:
                        <input type="text" name="transmission" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['transmission'] ?? $car['transmission'] ?? '' ?>" />
                        <?php if (isset($errors['transmission'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['transmission'] ?></span>
                        <?php endif; ?>
                    </p>
                    <p>
                        Year of manufacture:
                        <input type="number" name="year" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['year'] ?? $car['year'] ?? '' ?>" />
                        <?php if (isset($errors['year'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['year'] ?></span>
                        <?php endif; ?>
                    </p>
                    <p>
                        Number of seats:
                        <input type="number" name="passengers" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['passengers'] ?? $car['passengers'] ?? '' ?>" />
                        <?php if (isset($errors['passengers'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['passengers'] ?></span>
                        <?php endif; ?>
                    </p>
                    <div>
                        Price (HUF/day):
                        <input type="number" name="daily_price_huf" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['daily_price_huf'] ?? $car['daily_price_huf'] ?? '' ?>" />
                        <?php if (isset($errors['daily_price_huf'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['daily_price_huf'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        Image URL:
                        <input type="text" name="image" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['image'] ?? $car['image'] ?? '' ?>" />
                        <?php if (isset($errors['image'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['image'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="card-actions justify-end mt-4 flex gap-4">
                        <a href="admin_page.php" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Save" class="btn btn-primary" />
                    </div>
                    <input type="hidden" name="id" value="<?= $newId ?>" />
                    <input type="hidden" name="isNew" value="true" />
                </div>
            </form>
        <?php else: ?>
            <form method="POST" action="edit_query.php" class="card lg:card-side bg-base-100 shadow-xl w-2/3">
                <figure>
                    <img
                        src="<?= $car['image'] ?>"
                        alt="Car Image" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title">
                        Brand:
                        <input type="text" name="brand" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['brand'] ?? $car['brand'] ?? '' ?>"
                            placeholder="<?= $car['brand'] ?? '' ?>" />
                        <?php if (isset($errors['brand'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['brand'] ?></span>
                        <?php endif; ?>
                    </h2>
                    <p>
                        Model:
                        <input type="text" name="model" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['model'] ?? $car['model'] ?? '' ?>"
                            placeholder="<?= $car['model'] ?? '' ?>" />
                        <?php if (isset($errors['model'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['model'] ?></span>
                        <?php endif; ?>
                    </p>
                    <p>
                        Fuel:
                        <input type="text" name="fuel_type" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['fuel_type'] ?? $car['fuel_type'] ?? '' ?>"
                            placeholder="<?= $car['fuel_type'] ?? '' ?>" />
                        <?php if (isset($errors['fuel_type'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['fuel_type'] ?></span>
                        <?php endif; ?>
                    </p>
                    <p>
                        Shifter:
                        <input type="text" name="transmission" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['transmission'] ?? $car['transmission'] ?? '' ?>"
                            placeholder="<?= $car['transmission'] ?? '' ?>" />
                        <?php if (isset($errors['transmission'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['transmission'] ?></span>
                        <?php endif; ?>
                    </p>
                    <p>
                        Year of manufacture:
                        <input type="number" name="year" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['year'] ?? $car['year'] ?? '' ?>"
                            placeholder="<?= $car['year'] ?? '' ?>" />
                        <?php if (isset($errors['year'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['year'] ?></span>
                        <?php endif; ?>
                    </p>
                    <p>
                        Number of seats:
                        <input type="number" name="passengers" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['passengers'] ?? $car['passengers'] ?? '' ?>"
                            placeholder="<?= $car['passengers'] ?? '' ?>" />
                        <?php if (isset($errors['passengers'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['passengers'] ?></span>
                        <?php endif; ?>
                    </p>
                    <div>
                        Price (HUF/day):
                        <input type="number" name="daily_price_huf" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['daily_price_huf'] ?? $car['daily_price_huf'] ?? '' ?>"
                            placeholder="<?= $car['daily_price_huf'] ?? '' ?>" />
                        <?php if (isset($errors['daily_price_huf'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['daily_price_huf'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        Image URL:
                        <input type="text" name="image" class="input input-bordered w-full max-w-xs"
                            value="<?= $data['image'] ?? $car['image'] ?? '' ?>" />
                        <?php if (isset($errors['image'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['image'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="card-actions justify-end mt-4 flex gap-4">
                        <a href="admin_page.php" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Save" class="btn btn-primary" />
                    </div>
                    <input type="hidden" name="id" value="<?= $car['id'] ?>" />
                    <input type="hidden" name="isNew" value="false" ?>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>