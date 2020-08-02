<?php require "../include/pdo.php";

//if session don't have name
if (empty($_SESSION['user']))
    die("Not logged in");

//load autos
$sql = "SELECT * FROM `autos` WHERE `added_by`= :id ORDER BY `make` ASC;";

$statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

$statement->execute(array(':id' => $_SESSION['user']['user_id']));

$autos = ($statement->rowCount() > 0)
    ? $statement->fetchAll(PDO::FETCH_ASSOC)
    : null;
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
      <?php if (!empty($_SESSION["confirm"])) {
          echo '<p class="text-center font-weight-bold ' . $_SESSION["confirm"]['type'] . '">' . $_SESSION["confirm"]['msg'] . '<p>';
      }
      if (!empty($autos)) : ?>
        <div class="row">
          <div class="mt-4 col-12">
            <div class="card">
              <p class="card-header font-weight-bold bg-primary text-white">Automobiles Added By
                : <?= htmlentities($_SESSION['user']['full_name']) ?></p>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="text-center">
                      <th>ID</th>
                      <th>Year</th>
                      <th>Make</th>
                      <th>Mileage</th>
                      <th colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($autos as $auto) : ?>
                      <tr>
                          <td><?= htmlentities($auto['auto_id']) ?></td>
                        <td><?= htmlentities($auto['year']) ?></td>
                        <td><?= htmlentities($auto['make'], ENT_COMPAT, ini_get("default_charset"), false) ?></td>
                        <td><?= htmlentities($auto['mileage']) ?></td>
                        <td><a href="edit.php?user_id=<?= $auto['auto_id'] ?>" class="btn btn-warning">Edit</a></td>
                        <td><a href="delete.php?user_id=<?= $auto['auto_id'] ?>" class="btn btn-danger">Delete</a></td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr class="text-center">
                      <th>ID</th>
                      <th>Year</th>
                      <th>Make</th>
                      <th>Mileage</th>
                      <th colspan="2">Action</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>

                <ul class="list-group mx-3">

                </ul>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <p class="mt-3">
      <a href="add.php">Add New</a> |
      <a href="logout.php">Logout</a>
    </p>
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
