<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
    <title>Registration</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/7a2e7b22c5.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include_once "navigate.php" ?>
    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content flex-col lg:flex-row-reverse">
            <div class="text-center lg:text-left">
                <h1 class="text-5xl font-bold">Register now!</h1>
            </div>
            <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
                <form method="POST" action="register_query.php" class="card-body">

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" name="email" id="email" class="input input-bordered"
                            value="<?= $data['email'] ?? '' ?>" />
                        <?php if (isset($errors['email'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['email'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" name="name" id="name" class="input input-bordered"
                            value="<?= $data['name'] ?? '' ?>" />
                        <?php if (isset($errors['name'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['name'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" name="password" id="password" class="input input-bordered" />
                        <?php if (isset($errors['password'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['password'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Password again</span>
                        </label>
                        <input type="password" name="passwordConfirm" id="passwordConfirm" class="input input-bordered" />
                        <?php if (isset($errors['passwordConfirm'])): ?>
                            <span class="text-red-500 text-sm"><?= $errors['passwordConfirm'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-control mt-6">
                        <input type="submit" value="Register" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>