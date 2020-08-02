<?php

session_start();

//Database Connection Object
$server = "localhost";
$user = "hafijulislamadov_test";//"root"; //
$db = "hafijulislamadov_misc";//"misc"; //
$pass = "Hafijul14_M";//""; //
$port = 3306;

try {

    $pdo = new PDO("mysql:host=$server;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($pdo) {
        //error_log("Database Connected Successfully.");
    }
} catch (PDOException $error) {
    //error_log($error->getMessage() . ".");
    die("Connection Error: " . $error->getMessage());
}


function display_error($error)
{
    if (count($error) > 0) {
        echo '<ul class="list-group mb-2">';
        foreach ($error as $er) {
            echo '<li class="font-weight-bold text-danger text-center">' . $er . '</li>';
        }
        echo '</ul>';
    } else
        echo "";
}