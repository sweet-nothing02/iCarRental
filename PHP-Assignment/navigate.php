<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$loggedIn = count($_SESSION) > 0;
?>

<div class="navbar bg-base-100">
    <div class="flex-1">
        <a class="btn btn-ghost text-xl" href="index.php">iKarRental</a>
    </div>
    <div class="flex-none">
        <?php if (!$loggedIn): ?>
            <a href="login.php" class="btn">Login</a>
            <a href="registration.php" class="btn">Register</a>
        <?php else: ?>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <?= $_SESSION["name"][0] ?>
                    </div>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li>
                        <?php if ($_SESSION["email"] === "admin@ikarrental.hu"): ?>
                            <a class="justify-between" href="admin_page.php">
                                Profile
                            </a>
                        <?php else: ?>
                            <a class="justify-between" href="user_page.php">
                                Profile
                            </a>
                        <?php endif; ?>
                    </li>
                    <li><a href="logout_query.php">Logout</a></li>
                </ul>
            </div>
        <?php endif ?>
    </div>
</div>