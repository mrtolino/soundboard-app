<?php
  $file = filter_var($_GET['filename'], FILTER_SANITIZE_STRING);

  header('Content-type: audio/wav');
  readfile($file);
?>
