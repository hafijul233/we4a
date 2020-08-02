<?php

session_start();

//Database Connection Object
$server = "localhost";
$user = "hafijulislamadov_test";
$db = "hafijulislamadov_misc";
$pass = "Hafijul14_M";
$port = 3306;

try {

    $pdo = new PDO("mysql:host=$server;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($pdo) {
        error_log("Database Connected Successfully.");
    }
} catch (PDOException $error) {
    error_log($error->getMessage() . ".");
    die("Connection Error: " . $error->getMessage());
}

function session_data()
{
    if (!empty($_SESSION['msg']) && !empty($_SESSION['typ'])) {
        echo "<p class=\"text-" . $_SESSION['typ']
            . "font-weight-bold d-block\">" . $_SESSION['msg'] . "</p>";
        unset($_SESSION['msg']);
        unset($_SESSION['typ']);
    }
}