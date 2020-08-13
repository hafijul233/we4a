<?php require "../include/pdo.php";

//if session don't have name
if (empty($_SESSION['user'])) {
    die("ACCESS DENIED");
} //display data on form
elseif (!empty($_GET['profile_id']) && empty($_POST['insert'])) {
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
elseif (!empty($_GET['profile_id']) && !empty($_POST['insert'])) {
    $error = $confirm = [];
    $profile_id = intval($_GET['profile_id']);
    //Email Validation
    $first = filter_var(htmlentities($_POST['first_name']), FILTER_SANITIZE_STRING);
    $last = filter_var(htmlentities($_POST['last_name']), FILTER_SANITIZE_STRING);
    $email = filter_var(htmlentities($_POST['email']), FILTER_SANITIZE_EMAIL);
    $headline = filter_var(htmlentities($_POST['headline']), FILTER_SANITIZE_STRING);
    $summary = filter_var(htmlentities($_POST['summary']), FILTER_SANITIZE_STRING);
    $user_id = $_SESSION['user']['user_id'];

    //Make Value validation
    if ($first == '' || $first == NULL || $last == '' || $last == NULL
        || $email == '' || $email == NULL || $headline == '' || $email == NULL
        || $summary == '' || $summary == NULL
    ) {
        array_push($error, "All fields are required");
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        array_push($error, "Email address must contain @");
    }

    //no error found && validation passed
    if (count($error) == 0) {

        $sql = 'UPDATE profile SET `user_id` = :uid, `first_name` = :fn, `last_name` = :ln, ' .
            '`email` = :em, `headline` = :he, `summary` = :su WHERE `profile_id` = :id';
        $stmt = $pdo->prepare($sql);

        $result = $stmt->execute([
            ':id' => $profile_id,
            ':uid' => $user_id,
            ':fn' => $first,
            ':ln' => $last,
            ':em' => $email,
            ':he' => $headline,
            ':su' => $summary,
        ]);

        //edit failed
        if (!$result) {
            error_log("profile edited Failed");
            $confirm = ['type' => 'text-danger', 'msg' => "profile edited Failed"];
        } //edit succeed
        else {
            error_log("profile edited");
            $confirm = ['type' => 'text-success', 'msg' => "profile edited"];
        }

        //getting confirm message
        $_SESSION['confirm'] = $confirm;
        header("Location: index.php");
        return;
    }

    $_SESSION['errors'] = $error;
    header("Location: edit.php?profile_id=" . $profile_id);
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
    <h1 class="h1">Adding Profile for <?= $_SESSION['user']['name'] ?></h1>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <p class=" font-weight-bold card-header bg-success text-white">Edit Profile</p>
          <form action="edit.php?profile_id=<?= $_GET['profile_id'] ?>" accept-charset="UTF-8" method="post"
                autocomplete="off"
                spellcheck="false">
            <div class="card-body">
                <?= display_error() ?>
              <div class="form-group row">
                <label for="first_name" class="col-form-label col-md-3">
                  First Name
                  <span class="font-weight-bold text-danger">*</span>
                </label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="first_name" id="first_name"
                         size="128" minlength="1" maxlength="30" value="<?= $profile['first_name'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="last_name" class="col-form-label col-md-3">
                  Last Name
                  <span class="font-weight-bold text-danger">*</span>
                </label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="last_name" id="last_name"
                         size="128" minlength="1" maxlength="30"  value="<?= $profile['last_name'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-form-label col-md-3">
                  Email
                  <span class="font-weight-bold text-danger">*</span>
                </label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="email" id="email"
                         size="60" minlength="1" maxlength="60" value="<?= $profile['email'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="headline" class="col-form-label col-md-3">
                  Headline
                  <span class="font-weight-bold text-danger">*</span>
                </label>
                <div class="col-md-9">
                  <input type="text" id="headline" class="form-control" name="headline"
                         size="11" minlength="1" maxlength="255"  value="<?= $profile['headline'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="summary" class="col-form-label col-md-3">
                  Summary
                  <span class="font-weight-bold text-danger">*</span>
                </label>
                <div class="col-md-9">
                  <textarea id="summary" class="form-control" name="summary"
                            rows="8" cols="80"><?= $profile['summary'] ?></textarea>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="row justify-content-between">
                <input class="btn btn-success" type="submit" name="insert" value="Save">
                <input class="btn btn-secondary" type="submit" name="cancel" value="Cancel">
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
