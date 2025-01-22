<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION["email"] === "admin@ikarrental.hu") {
    header('Location: index.php');
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
session_unset();
session_destroy();
