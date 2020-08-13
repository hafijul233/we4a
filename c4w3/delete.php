<?php require "../include/pdo.php";

//if session don't have name
if (empty($_SESSION['user'])) {
    die("ACCESS DENIED");
} //display data on form
elseif (!empty($_GET['profile_id']) && empty($_POST['delete'])) {
//display form fields with old one's
    $sql = "SELECT * FROM `profile` WHERE `profile_id` = :profile;";
    $profile_id = intval($_GET['profile_id']);
    $statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

    $statement->execute(array(
        ':profile' => $profile_id
    ));

    $profile = ($statement->rowCount() > 0)
        ? $statement->fetchAll(PDO::FETCH_ASSOC)[0]
        : null;

} //update form data
elseif (!empty($_GET['profile_id']) && !empty($_POST['delete'])) {
    $profile_id = intval($_GET['profile_id']);
    $user_id = $_SESSION['user']['user_id'];

    $sql = "DELETE FROM `profile` WHERE `profile_id` = :id;";
    $statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

    $result = $statement->execute(array(
        ':id' => $profile_id,
    ));

    //edit failed
    if (!$result) {
        error_log("profile deleted Failed");
        $confirm = ['type' => 'text-danger', 'msg' => "profile deleted Failed"];
    } //edit succeed
    else {
        error_log("profile deleted");
        $confirm = ['type' => 'text-success', 'msg' => "profile deleted"];
    }

    //getting confirm message
    $_SESSION['confirm'] = $confirm;
    header("Location: index.php");
    return;

} else if (isset($_POST['cancel']) && $_POST['cancel'] == "Cancel") {
    header("Location: index.php");
    return;
}
?>
<!doctype html>
<html lang="en" class="h-100">
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
    <h1 class="h1">Delete Profile</h1>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <p class=" font-weight-bold card-header bg-info text-white">Delete Automobiles</p>
          <form action="<?= "delete.php?profile_id=" . $profile_id ?>" accept-charset="UTF-8" method="post" autocomplete="off"
                spellcheck="false">
            <div class="card-body">
                <?= display_error() ?>
              <p class="font-weight-bold text-dark">First Name:
                  <?= htmlentities($profile['first_name'], ENT_COMPAT, ini_get("default_charset"), false) ?></p>
              <p class="font-weight-bold text-dark">Last Name:
                  <?= htmlentities($profile['last_name'], ENT_COMPAT, ini_get("default_charset"), false) ?></p>
            </div>
            <div class="card-footer">
              <div class="row justify-content-between">
                <input class="btn btn-success" type="submit" name="delete" value="Delete">
                <a href="index.php">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
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
