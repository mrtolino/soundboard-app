<?php
  define('DB_USER', 'root');
  define('DB_PWORD', 'ShaNasaHugh0987^%');
  define('DB_NAME', 'Soundboard');
  define('DB_HOST', 'localhost');
  define('DB_PORT', 3306);

  $link = mysqli_init();
  $success = mysqli_real_connect(
     $link,
     DB_HOST,
     DB_USER,
     DB_PWORD,
     DB_NAME,
     DB_PORT
  );

  if (!$success) {
    die("Connection failed: ".mysqli_connect_error());
  }
?>
