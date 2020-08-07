<?php
$title = "Mohammad Hafijul Islam";
$std = 43;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Guessing Game for <?= $title ?></title>
</head>
<body>
<h1>Welcome to <?= $title ?>'s Guessing Game</h1>
<?php
if (!isset($_GET['guess'])) {
    echo "Missing guess parameter";
} else if ($_GET['guess'] == '') {
    echo "Your guess is too short";
} else if (is_numeric($_GET['guess'])  === FALSE) {
    echo "Your guess is not a number";
} else if ($_GET['guess'] < $std) {
    echo "Your guess is too low";
} else if ($_GET['guess'] > $std) {
    echo "Your guess is too high";
} else if ($_GET['guess'] == $std) {
    echo "Congratulations - You are right";
} else {
    echo "It is a Mystery";
}

?>
</body>
</html>
