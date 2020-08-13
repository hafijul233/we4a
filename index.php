<?php
$tasks = scandir(__DIR__);
$assignments = [];
$links = json_decode(file_get_contents('list.json'), true);

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
            'link' => $temp[3] . '/',
            'detail' => $links[$task],
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
              <a class="text-dark text-decoration-none" href="<?= $assignment['detail'] ?>" target="_blank">&rightarrow;Specification
                for this
                Application</a>
            </p>
          <?php
          endforeach;
      endif;
      ?>
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
