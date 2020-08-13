<?php require "../include/pdo.php";

$salt = "XyZzy12*_";

if (isset($_POST['submit']) && $_POST['submit'] == 'Log In') {
    $error = [];
    //Email Validation
    $email = filter_var(htmlentities($_POST['email']), FILTER_SANITIZE_EMAIL);
    if ($email == '' || $email == NULL) {
        array_push($error, "Email address field is required.");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($error, "Email must have an at-sign (@)");
    }

    //password validation
    $password = htmlentities($_POST['pass']);
    if ($password == '' || $password == NULL) {
        array_push($error, "Password field is required.");
    }

    //no error found && validation passed
    if (count($error) == 0) {
        $encrypt = md5($salt . $password);

        $sql = "SELECT * FROM `users` WHERE `email` = :email AND `password` = :password LIMIT 1";
        $statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $statement->execute(array(':email' => $email, ':password' => $encrypt));
        $red = $statement->fetchAll(PDO::FETCH_ASSOC);

        //login failed
        if (!$red) {
            error_log("Login Fail.  $email  $encrypt");
            array_push($error, "Incorrect Password.");

            //errors collection
            $_SESSION['errors'] = $error;

        } //login succeed
        else {
            $_SESSION['user'] = $red[0];
            error_log("Login Success. $email");

            //redirect to view.php page as get req
            header("Location: index.php");
            return;
        }
    }

    //errors collection
    $_SESSION['errors'] = $error;

    //redirect to this page as get req
    header("Location: login.php");
    return;
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
          spellcheck="true" id="form" onsubmit="return validation();">
      <div class="text-center mb-4">
        <img class="mb-4" src="../assets/img/icons.jpg" alt="Logo" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please Log In</h1>
        <p class="lead">
          For a password hint, view source and find a password hint
          in the HTML comments.
          <!-- Email: ('Chuck','csev@umich.edu','123'), ('Glenn','gg@umich.edu','123'); -->
          <!-- Hint: The password is the three character name of the
          programming language used in this class (all lower case)
          followed by 123. -->
        </p>
      </div>
        <?= display_error() ?>
      <div class="form-label-group">
        <input type="text" id="inputEmail" class="form-control"
               placeholder="Email address" name="email" size="255" autofocus>
        <label for="inputEmail">Email address</label>
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
<script type="text/javascript">
    function validation() {
//if js not enabled in machine
        try {
            addr = document.getElementById('inputEmail').value;
            pw = document.getElementById('inputPassword').value;

            console.log("Validating addr=" + addr + " pw=" + pw);

            if (addr == null || addr == "" || pw == null || pw == "") {
                alert("Both fields must be filled out");
                return false;
            } else if (addr.indexOf('@') == -1) {
                alert("Invalid email address");
                return false;
            } else
                return true;
        } catch (e) {
            console.log(e);
            return false;
        }
        //after alert stop page
        return false;
    }
</script>
</body>
</html>
