<?php require "../include/pdo.php";

//if session don't have name
if (empty($_GET['name']))
    die("Name parameter missing");

$verdict = null;

// Set up the values for the game...
// 0 is Rock, 1 is Paper, and 2 is Scissors
$names = array('Rock', 'Paper', 'Scissors');
$human = isset($_POST["human"]) ? intval($_POST['human']) : -1;
// TODO: Make the computer be random
$computer = rand(0, 2);

function check($human, $computer)
{
    if ($human == $computer)
        return "Tie";

    else if ($human == 2 && $computer == 1)
        return "You Win";

    else if ($human == 1 && $computer == 0)
        return "You Win";

    else if ($human == 0 && $computer == 2)
        return "You Win";

    else
        return "You Lose";
}

if (isset($_POST['human'])) {
    $human = $_POST['human'];
}

?>
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
    <h1 class="h1">Rock Paper Scissors Game</h1>
    <p>Welcome : <?= $_GET['name'] ?></p>
    <p class="mt-3">
      <a href="add.php">Add New</a> |
      <a href="logout.php">Logout</a>
    </p>
    <div class="card">
      <h5 class="card-header bg-success text-white font-weight-bold">Game Board</h5>
      <div class="card-body">
        <form action="game.php?name=<?= $_GET['name'] ?>" method="post" accept-charset="UTF-8"
              spellcheck="false">
          <div class="form-group row mb-2">
            <label for="staticEmail2" class="col-form-label col-md-6">Choose Hand-sign</label>
            <div class="col-md-6">
              <select class="form-control" name="human" id="staticEmail2">
                <option value="-1">Select</option>
                <option value="0">Rock</option>
                <option value="1">Paper</option>
                <option value="2">Scissors</option>
                <option value="3">Test</option>
              </select>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12 text-center">
              <input type="submit" value="Play" class="btn btn-lg btn-primary">
              <input type="submit" name="logout" value="Logout" class="btn btn-lg btn-secondary">
            </div>
          </div>
        </form>
        <div class="row mt-3">
          <div class="col-12">
          <pre>
          <?php if ($human == -1) {
echo "Please select a strategy and press Play." . PHP_EOL;
          } else if ($human == 3) {
              for ($c = 0; $c < 3; $c++) {
                  for ($h = 0; $h < 3; $h++) {
                      $r = check($c, $h);
print "Human=$names[$h] Computer=$names[$c] Result=" . check($h, $c) . "\n";
                  }
              }
          } else {
echo "Your Play=$names[$human] Computer Play=$names[$computer] Result=" . check($human, $computer) . "\n";
          } ?>
          </pre>
          </div>
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
