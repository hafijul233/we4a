<?php
$tasks = scandir(__DIR__);
$assignments = [];
foreach ($tasks as $task) {
    if ($task == '.' || $task == '..' || $task == 'assets' || $task == 'include' || $task == '.git'
        || $task == 'database' || $task == 'resources' || is_file($task) || $task == ".idea") continue;

    else {
        preg_match('/c[\d]+/', $task, $course);
        preg_match('/w[\d]+/', $task, $week);
        $temp = array_merge($course, $week);

        $temp[0] = str_replace('c', 'Course : ', $temp[0]) . " ";
        $temp[1] = str_replace('w', 'Week : ', $temp[1]) . " ";
        $temp[2] = "Assignments";
        $temp[3] = $task;

        array_push($assignments, [
            'title' => $temp[0] . $temp[1] . $temp[2],
            'link' => $temp[3] . '/'
        ]);
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Mohammad Hafijul Islam - Web Applications for Everybody</title>
  <link rel="shortcut icon" href="assets/img/icons.jpg" type="image/jpg">
  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template -->
  <link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="d-flex flex-column h-100">
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
  <div class="container">
    <h1 class="h1">Welcome to Web Applications for Everybody Course</h1>

      <?php if (!empty($assignments)) :
          foreach ($assignments as $assignment) : ?>
            <a class="font-weight-bold" href="<?= $assignment['link'] ?>"><?= $assignment['title'] ?></a>
            <p class="lead">
              <a class="text-dark text-decoration-none" href="https://www.wa4e.com/assn/autosdb" target="_blank">&rightarrow;Specification
                for this
                Application</a>
            </p>
          <?php
          endforeach;
      endif;
      ?>
    <!--    <a class="font-weight-bold" href="week-4/index.php">Week 4 Assignment</a>
        <p class="lead">
          <a class="text-dark" href="https://www.wa4e.com/assn/autosess" target="_blank">Specification for this
            Application</a>
        </p>
        <a class="font-weight-bold" href="week-5/index.php">Week 5 Assignment</a>
        <p class="lead">
          <a class="text-dark" href="https://www.wa4e.com/assn/autosess" target="_blank">Specification for this
            Application</a>
        </p>-->
  </div>
</main>

<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">&copy; <?= date('Y') ?> . Mohammad Hafijul Islam</span>
  </div>
</footer>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.js"></script>
</body>
</html>
