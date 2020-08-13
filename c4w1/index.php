<?php require "../include/pdo.php";

//load autos
$sql = "SELECT * FROM `profile`;";

$statement = $pdo->query($sql);
$autos = ($statement->rowCount() > 0)
    ? $statement->fetchAll(PDO::FETCH_ASSOC)
    : null;
?>
<!doctype html>
<html lang="en" class="h-100">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?>'s Resume Registry</title>
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
    <h1 class="h1"><?= $title ?>'s Resume Registry</h1>
      <?php if (empty($_SESSION['user'])) : ?>
        <a class="font-weight-bold" href="login.php">Please log in</a>
      <?php else :
          //show confirmation message
          if (!empty($_SESSION["confirm"])) {
              echo '<p class="text-center font-weight-bold ' . $_SESSION["confirm"]['type'] . '">' . $_SESSION["confirm"]['msg'] . '<p>';
              unset($_SESSION["confirm"]);
          }
          ?>
        <a href="logout.php">Logout</a>
      <?php endif;
      //display data
      if (!empty($autos)) : ?>
        <div class="row">
          <div class="mt-4 col-12">
            <div class="card">
              <p class="card-header font-weight-bold bg-primary text-white">User Profile List</p>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="text-center">
                      <th>ID</th>
                      <th>Name</th>
                      <th>Heading</th>
                      <th colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($autos as $auto) : ?>
                      <tr>
                        <td><?= htmlentities($auto['profile_id'], ENT_COMPAT, ini_get("default_charset"), false) ?></td>
                        <td><a href="view.php?profile_id=<?= $auto['profile_id'] ?>">
                                <?= htmlentities($auto['first_name'] . ' ' . $auto['last_name'], ENT_COMPAT, ini_get("default_charset"), false) ?>
                          </a>
                        </td>
                        <td><?= htmlentities($auto['headline'], ENT_COMPAT, ini_get("default_charset"), false) ?></td>
                        <td class="text-center"><a href="edit.php?profile_id=<?= $auto['profile_id'] ?>"
                                                   class="btn btn-warning">Edit</a></td>
                        <td class="text-center"><a href="delete.php?profile_id=<?= $auto['profile_id'] ?>"
                                                   class="btn btn-danger">Delete</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr class="text-center">
                      <th>ID</th>
                      <th>Name</th>
                      <th>Heading</th>
                      <th colspan="2">Action</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif;
      if (!empty($_SESSION['user'])) : ?>
        <p class="mt-3">
          <a href="add.php">Add New Entry</a>
        </p>
      <?php endif; ?>
    <p class="lead mt-3">
      <b>Note:</b> Your implementation should retain data across multiple
      logout/login sessions. This sample implementation clears all its data
      periodically - which you should not do in your implementation.
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
