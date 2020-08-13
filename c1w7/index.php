<?php require "../include/pdo.php";

$default = [
    'type' => 'text-danger',
    'msg' => "Not found"
];

$time_diff = "";

function isValidMd5($md5)
{
    return preg_match('/^[a-f0-9]{32}$/', $md5);
}

if (isset($_GET['submit']) && $_GET['submit'] == 'Crack MD5') {
    //dat validation
    $pin_value = filter_var(htmlentities($_GET['md5']), FILTER_SANITIZE_STRING);

    $start_time = microtime(true);

    $trials = [];
    $rev_pin = '';
    for ($i = 0; $i < 10000; $i++) {
        $trial_pin = str_pad(strval($i), 4, "0", STR_PAD_LEFT);
        $trial_md5 = hash('md5', $trial_pin);
        array_push($trials, ['md5' => $trial_md5, 'pin' => $trial_pin]);
        if ($trial_md5 == $pin_value) {
            $rev_pin = $trial_pin;
        } else if ($rev_pin != '' && count($trials) >= 15) {
            break;
        }
    }

    if ($rev_pin != '') {
        $default = [
            'type' => 'text-success',
            'msg' => $rev_pin
        ];
    }
    //shuffle array for fun
    shuffle($trials);
    //execution time
    $time_diff = microtime(true) - $start_time;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?> - MD5 Cracker</title>
  <link rel="shortcut icon" href="../assets/img/icons.jpg" type="image/jpg">
  <!-- Bootstrap core CSS -->
  <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template -->
  <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="d-flex flex-column h-100">
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
  <div class="text-center mb-4">
    <h1 class="h3 mb-3 font-weight-normal">MD5 Cracker</h1>
  </div>
  <form class="form-inline" action="index.php" method="get" accept-charset="UTF-8" autocomplete="off"
        spellcheck="true">
      <?= display_error() ?>
    <div class="form-label-group mr-3">
      <input type="text" id="inputEmail" class="form-control"
             placeholder="Email address" name="md5" size="32">
      <label for="inputEmail">MD5 HASH</label>
    </div>
    <div class="form-group mt-n3">
      <input class="btn btn-lg btn-primary"
             type="submit" name="submit" value="Crack MD5">
    </div>
  </form>
  Original Text: <span class="font-weight-bold <?= $default['type'] ?>"><?= $default['msg'] ?></span>
  <pre>
    <p>Debug Output:</p>
<?php
if (!empty($trials)) {
    $i = 1;
    foreach ($trials as $trial) {
        if ($i <= 15) {
            echo $trial['md5'] . " " . $trial['pin'] . PHP_EOL;
        } else
            break;

        $i++;
    }
    echo "Elapsed time:" . $time_diff;
}
?>
</pre>
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
