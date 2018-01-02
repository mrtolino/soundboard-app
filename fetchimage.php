<?php
  $file = filter_var($_GET['filename'], FILTER_SANITIZE_STRING);

  header('Content-type: image/png');
  readfile($file);
?>
