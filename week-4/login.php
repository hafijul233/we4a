<?php require "../include/pdo.php";

$error = [];

if (isset($_POST['login']) && $_POST['login'] == 'submit') {
    //Email Validation
    $email = filter_var(htmlentities($_POST['email']), FILTER_SANITIZE_EMAIL);
    if ($email == '' || $email == NULL) {
        array_push($error, "Email address field is required.");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($error, "Invalid Email Address.");
    }

    //password
    $password = htmlentities($_POST['password']);

    if ($password == '' || $password == NULL) {
        array_push($error, "Password address field is required.");
    } else if (strlen($password) < 5 || strlen($password) > 100) {
        array_push($error, "Invalid Password Size.");
    }

    //no error found && validation passed
    if (count($error) == 0) {
        $encrypt = md5($password);

        $sql = "SELECT * FROM `users` WHERE `email` = :email AND `stored_hash` = :password LIMIT 1";
        $statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $statement->execute(array(':email' => $email, ':password' => $encrypt));
        $red = $statement->fetch();

        //login failed
        if (!$red) {
            error_log("Login Fail.  $email  $encrypt");
            array_push($error, "Incorrect Password.");
        } //login succeed
        else {

            error_log("Login Success. $email");
            array_push($error, "Login Successful.");
            header("Location: autos.php?name=" . urlencode($email));
        }

    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Mohammad Hafijul Islam - Autos Database</title>
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
          <!-- Hint: The password is the three character name of the
          programming language used in this class (all lower case)
          followed by 123. -->
        </p>
      </div>
        <?php if (count($error) > 0) : ?>
          <ul class="list-group mb-2">
              <?php foreach ($error as $er) : ?>
                <li class="font-weight-bold text-danger text-center"><?= $er ?></li>
              <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      <div class="form-label-group">
        <input type="text" id="inputEmail" class="form-control"
               placeholder="Email address" name="email" size="255" required autofocus>
        <label for="inputEmail">Email address</label>
        <span class="valid-feedback" id="emailError"></span>
      </div>

      <div class="form-label-group">
        <input type="password" id="inputPassword" class="form-control"
               placeholder="Password" name="password" required>
        <label for="inputPassword">Password</label>
        <span class="valid-feedback" id="passwordError"></span>
      </div>
      <div class="row">
        <div class="col-6">
          <button class="btn btn-lg btn-primary btn-block"
                  type="submit" name="login" value="submit">Log in
          </button>
        </div>
        <div class="col-6">
          <button class="btn btn-lg btn-secondary btn-block" type="reset">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</main>
<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">&copy; <?= date('Y') ?>. Mohammad Hafijul Islam</span>
  </div>
</footer>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.js"></script>
</body>
</html>
