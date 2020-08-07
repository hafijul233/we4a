<?php
$title = "Mohammad Hafijul Islam";
$asci_art =
    '   $$      $$
     $$$    $$$
     $$$$  $$$$  
     $$ $$$$ $$  
     $$  $$  $$ 
     $$      $$  
     $$      $$';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?> PHP</title>
</head>
<body>
<h1><?= $title ?> PHP</h1>
<p>The SHA256 hash of "<?php echo $title ?>" is <?php print hash('sha256', $title) ?></p>
<pre>ASCII ART:
  <?php print($asci_art); ?>
</pre>
<a href="check.php">Click here to check the error setting</a>
<br/>
<a href="fail.php">Click here to cause a traceback</a>
</body>
</html>
