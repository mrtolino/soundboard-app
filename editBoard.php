<?php
  session_start();
  if (!$_SESSION['allowed']) {
    header('Location: index.php');
  }

  require_once 'helperscripts/config.inc';

  $user = $_SESSION['user'];
  $oldTitle = filter_var($_GET['oldTitle'], FILTER_SANITIZE_STRING);
  $newTitle = filter_var($_GET['newTitle'], FILTER_SANITIZE_STRING);
  $public = 0;

  if (isset($_GET['public'])) {
    $public = 1;
  }

  $stmt = $link->prepare("update Boards set title=?, public=? where title=?");
  if ($stmt === FALSE) {
    die ("Mysql Error: " . $mysqli->error);
  }
  $stmt->bind_param('sis', $newTitle, $public, $oldTitle);
  $result = $stmt->execute();

  $_SESSION['edit_board_error'] = $result?"":"Could not update board!";


  /*if ($public == 1) {
    $sql = "update Boards set title='$newTitle', public='1' where title='$oldTitle'";
    $result = mysqli_query($link, $sql);

    if ($result == 1) {
      $_SESSION['edit_board_error'] = "";
    } else {
      $_SESSION['edit_board_error'] = "Could not update board!";
    }
  } else if (!$public) {
    $sql = "update Boards set title='$newTitle', public='0' where title='$oldTitle'";
    $result = mysqli_query($link, $sql);

    if ($result == 1) {
      $_SESSION['edit_board_error'] = "";
    } else {
      $_SESSION['edit_board_error'] = "Could not update board!";
    }
  } else {
    $_SESSION['edit_board_error'] = "Input parameters are not valid.";
  }*/
  $stmt->close();

  header('Location: myboards.php');
?>
