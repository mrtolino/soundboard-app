<?php
  session_start();
  if (!$_SESSION['allowed']) {
    header('Location: login.php');
  }

  require_once 'helperscripts/config.inc';

  $user = $_SESSION['user'];
  $oldTitle = filter_var($_GET['oldTitle'], FILTER_SANITIZE_VAR);
  $newTitle = filter_var($_GET['newTitle'], FILTER_SANITIZE_VAR);

  // Update title
  $sql = "update Boards set title = '$newTitle' where title = '$oldTitle'";
  $result = mysqli_query($link, $sql);

  if ($result == 1) {
    $_SESSION['edit_title_error'] = "";
  } else {
    $_SESSION['edit_title_error'] = mysqli_error($link);
  }

  header('Location: myboards.php');

?>
