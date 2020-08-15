<?php require "../include/pdo.php";

//if session don't have name
if (empty($_SESSION['user'])) {
    die("ACCESS DENIED");
} //display data on form

elseif (!empty($_GET['profile_id'])) {
    $profile_id = intval($_GET['profile_id']);

    //display form fields with old one's
    $sql = "SELECT * FROM `profile` WHERE `profile_id` = :profile;";
    $statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

    $statement->execute(array(
        ':profile' => $profile_id
    ));

    $profile = ($statement->rowCount() > 0)
        ? $statement->fetchAll(PDO::FETCH_ASSOC)[0]
        : null;

    //positions
    //display form fields with old one's
    $sql = "SELECT * FROM `position` WHERE `profile_id` = :profile;";
    $statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

    $statement->execute(array(
        ':profile' => $profile_id
    ));

    $positions = ($statement->rowCount() > 0)
        ? $statement->fetchAll(PDO::FETCH_ASSOC)
        : null;
} //update form data

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
          <p class=" font-weight-bold card-header bg-success text-white">Profile Detail</p>
          <div class="card-body">
              <?= display_error() ?>
            <div class="form-group row">
              <label for="first_name" class="col-form-label col-md-3">
                First Name
                <span class="font-weight-bold text-danger">*</span>
              </label>
              <div class="col-md-9">
                <p class="font-weight-bold"><?= $profile['first_name'] ?></p>
              </div>
            </div>
            <div class="form-group row">
              <label for="last_name" class="col-form-label col-md-3">
                Last Name
                <span class="font-weight-bold text-danger">*</span>
              </label>
              <div class="col-md-9">
                <p class="font-weight-bold"><?= $profile['last_name'] ?></p>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-form-label col-md-3">
                Email
                <span class="font-weight-bold text-danger">*</span>
              </label>
              <div class="col-md-9">
                <p class="font-weight-bold"><?= $profile['email'] ?></p>
              </div>
            </div>
            <div class="form-group row">
              <label for="headline" class="col-form-label col-md-3">
                Headline
                <span class="font-weight-bold text-danger">*</span>
              </label>
              <div class="col-md-9">
                <p class="font-weight-bold"><?= $profile['headline'] ?></p>
              </div>
            </div>
            <div class="form-group row">
              <label for="summary" class="col-form-label col-md-3">
                Summary
                <span class="font-weight-bold text-danger">*</span>
              </label>
              <div class="col-md-9">
                <p class="font-weight-bold"><?= $profile['summary'] ?></p>
              </div>
            </div>
              <?php if (!empty($positions)) : ?>
            <div class="form-group row">
              <ul>
                  <?php foreach ($positions as $position)  : ?>
                    <li><?= $position['year'] . "/ " . $position['description'] ?></li>
                  <?php endforeach; ?>
              </ul>
                <?php endif; ?>
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
<script typeof="text/javascript">
    function addBlock() {
        var template = "                <div class=\"position\">\n" +
            "                  <div class=\"form-group row\">\n" +
            "                    <label class=\"col-form-label col-md-3\">Year: </label>\n" +
            "                    <div class=\"col-md-7\">\n" +
            "                      <input class=\"form-control\" name=\"year[]\" type=\"text\">\n" +
            "                    </div>\n" +
            "                    <div class=\"col-md-2\">\n" +
            "                      <button type=\"button\" class=\"btn btn-danger\" onclick=\"removeBlock(this);\">-</button>\n" +
            "                    </div>\n" +
            "                  </div>\n" +
            "                  <div class=\"form-group row\">\n" +
            "                    <label class=\"col-form-label col-md-3\">Description:</label>\n" +
            "                    <div class=\"col-md-9\">\n" +
            "                      <textarea class=\"form-control\" name=\"description[]\" rows=\"8\"></textarea>\n" +
            "                    </div>\n" +
            "                  </div>\n" +
            "                </div>";

        $("#positions").append(template);
    }

    function removeBlock(c) {
        $(c).parent().parent().parent().remove();
    };
</script>
</body>
</html>
