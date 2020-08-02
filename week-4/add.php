<?php require "../include/pdo.php";

//if session don't have name
if (empty($_SESSION['user']))
    die("Not logged in");

if (isset($_POST['insert']) && $_POST['insert'] == "Add") {
    $error = $confirm = [];
    //Email Validation
    $make = filter_var(htmlentities($_POST['make']), FILTER_SANITIZE_STRING);
    $year = filter_var(htmlentities($_POST['year']), FILTER_SANITIZE_STRING);
    $mileage = filter_var(htmlentities($_POST['mileage']), FILTER_SANITIZE_STRING);
    $url = filter_var(htmlentities($_POST['url']), FILTER_SANITIZE_URL);
    $user_id = $_SESSION['user']['user_id'];

    //Make Value validation
    if ($make == '' || $make == NULL) {
        array_push($error, "Make is required");
    }

    //Year value Validation
    if ($year == '' || $year == NULL) {
        array_push($error, "Year field is required.");
    }
    else if (preg_match("/^[\d]+$/i", $year) == 0) {
        //input is always string [ is_int()/ is_integer() ] not work
        //and database type int so [ is_numeric()/ intval() ] data may get truncated
        //so made a custom validation rule
        array_push($error, "Mileage and year must be numeric");
    }

    //Mileage Value validation
    if ($mileage == '' || $mileage == NULL) {
        array_push($error, "Mileage field is required.");
    }
    elseif (preg_match("/^[\d]+$/i", $mileage) == 0) {
        //input is always string [ is_int()/ is_integer() ] not work
        //and database type int so [ is_numeric()/ intval() ] data may get truncated
        //so made a custom validation rule
        array_push($error, "Mileage and year must be numeric");
    }

    //URL Validation
    if (strlen($url) > 0) {
        if (strlen($url) > 900 || strlen($url) < 1) {
            array_push($error, "Very Large URL. Try Shorting Url");
        } else if (!filter_var($url, FILTER_VALIDATE_URL)) {
            //filter valid url based on RFC 2396 [http://www.faqs.org/rfcs/rfc2396.html]
            //generic syntax rule
            array_push($error, "URL has Invalid Characters");
        }
    }

    else $url = null;

    //no error found && validation passed
    if (count($error) == 0) {

        $sql = "INSERT INTO `autos`(`make`, `year`, `mileage`, `added_by`, `photo`) " .
            "VALUES (:make, :year, :mileage, :user, :photo)";
        $statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $result = $statement->execute(array(
            ':make' => $make,
            ':year' => $year,
            ':mileage' => $mileage,
            ':user' => $user_id,
            ':photo' => $url
        ));

        //insert failed
        if (!$result) {
            error_log("Record Insert Failed");
            $confirm = ['type' => 'text-danger', 'msg' => "Record Insert Failed"];
        }
        //insert succeed
        else {
            error_log("Record Insert");
            $confirm = ['type' => 'text-success', 'msg' => "Record Insert Successfully"];
        }

        //getting confirm message
        $_SESSION['confirm'] = $confirm;
        header("Location: view.php");
        return;
    }

    $_SESSION['errors'] = $error;
    header("Location: add.php");
    return;

} else if (isset($_POST['cancel']) && $_POST['cancel'] == "Cancel") {
    header("Location: view.php");
}

?>
<!doctype html>
<html lang="en" class="h-100">
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
    <h1 class="h1">Tracking Autos for <?= $_SESSION['user']['email'] ?></h1>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <p class=" font-weight-bold card-header bg-success text-white">Insert New Mileage</p>
          <form action="add.php" accept-charset="UTF-8" method="post" autocomplete="off"
                spellcheck="false">
            <div class="card-body">
                <?= display_error() ?>
              <div class="form-group row">
                <label for="make" class="col-form-label col-md-3">
                  Make
                  <span class="font-weight-bold text-danger">*</span>
                </label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="make" id="make"
                         size="128" minlength="1" maxlength="128">
                </div>
              </div>
              <div class="form-group row">
                <label for="year" class="col-form-label col-md-3">
                  Year
                  <span class="font-weight-bold text-danger">*</span>
                </label>
                <div class="col-md-9">
                  <input type="text" id="year" class="form-control" name="year"
                         size="11" minlength="1" maxlength="11">
                </div>
              </div>
              <div class="form-group row">
                <label for="mileage" class="col-form-label col-md-3">
                  Mileage
                  <span class="font-weight-bold text-danger">*</span>
                </label>
                <div class="col-md-9">
                  <input type="text" id="mileage" class="form-control" name="mileage"
                         size="11" minlength="1" maxlength="11">
                </div>
              </div>
              <div class="form-group row">
                <label for="url" class="col-form-label col-md-3">
                  Photo(URL)
                </label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="url" id="url"
                         size="255" minlength="1" maxlength="255">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="row justify-content-between">
                <input class="btn btn-success" type="submit" name="insert" value="Add">
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
    <span class="text-muted">&copy; <?= date('Y') ?> . Mohammad Hafijul Islam</span>
  </div>
</footer>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.js"></script>
</body>
</html>
