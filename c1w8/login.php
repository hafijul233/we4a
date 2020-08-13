<?php require "../include/pdo.php";

$salt = 'XyZzy12*_';

if (isset($_POST['who']) && isset($_POST['pass'])) {
    $error = [];
    //Email Validation
    $who = filter_var(htmlentities($_POST['who']), FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

    if ($who == '' || $who == NULL || $password == '' || $password == NULL) {
        array_push($error, "User name and password are required.");
    }

    else {
        $stored_hash = "1a52e17fa899cf40fb04cfc42e6352f1";
        //password match
        if ($stored_hash == hash('md5', $salt . $password)) {
            header("location: game.php?name=" . $who);
            return;
        }
        array_push($error, "Incorrect password");
        //errors collection
        $_SESSION['errors'] = $error;

        //redirect to this page as get req
        header("Location: login.php");
        return;
    }
} //login cancelled
elseif (isset($_POST['cancel']) && $_POST['cancel'] == 'Cancel') {
    //redirect to index.php
    header('Location: index.php');
    return;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?> - Autos Database</title>
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
    <form class="form-signin" action="login.php" method="post" accept-charset="UTF-8" autocomplete="off"
          spellcheck="true">
      <div class="text-center mb-4">
        <img class="mb-4" src="../assets/img/icons.jpg" alt="Logo" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please Log In</h1>
        <p class="lead">
          For a password hint, view source and find a password hint
          in the HTML comments.
          <!-- Hint: The password is the four character sound a cat
          makes (all lower case) followed by 123. -->
        </p>
      </div>
        <?= display_error() ?>
      <div class="form-label-group">
        <input type="text" id="inputEmail" class="form-control"
               placeholder="Username" name="who" size="255" autofocus>
        <label for="inputEmail">Username</label>
      </div>

      <div class="form-label-group">
        <input type="password" id="inputPassword" class="form-control"
               placeholder="Password" name="pass">
        <label for="inputPassword">Password</label>
      </div>
      <div class="row">
        <div class="col-6">
          <input class="btn btn-lg btn-primary btn-block"
                 type="submit" name="submit" value="Log In">
        </div>
        <div class="col-6">
          <input class="btn btn-lg btn-secondary btn-block" type="submit" name="cancel" value="Cancel">
        </div>
      </div>
    </form>
  </div>
</main>
<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">&copy; <?= date('Y') ?>. <?= $title ?></span>
  </div>
</footer>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.js"></script>
</body>
</html>
