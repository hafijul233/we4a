<?php require "../include/pdo.php"; ?>
<!doctype html>
<html lang="en" class="h-100">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?> - Rock Paper Scissors </title>
  <link rel="shortcut icon" href="../assets/img/icons.jpg" type="image/jpg">
  <!-- Bootstrap core CSS -->
  <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template -->
  <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="d-flex flex-column h-100">
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
  <div class="container">
    <h1 class="h1">Welcome to Broken Rock Paper Scissors</h1>
    <a class="font-weight-bold" href="login.php">Please Log In</a>
    <p class="lead">Attempt to go to
      <a class="font-weight-bold" href="game.php">game.php</a>
      <code>
        without logging in - it should fail with an error message.
      </code>
    </p>
    <p>
      <a href="https://www.wa4e.com/assn/rps/" target="_blank">
        Specification for this Application
      </a>
    </p>
  </div>
</main>

<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">&copy; <?= date('Y') ?> . <?= $title ?></span>
  </div>
</footer>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.js"></script>
</body>
</html>
