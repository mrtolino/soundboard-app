<?php
  session_start();
  if (!$_SESSION['allowed']) {
    header('Location: index.php');
  }

  require_once 'helperscripts/config.inc';

  $user = $_SESSION['user'];
  $title = filter_var($_POST['boardTitle'], FILTER_SANITIZE_STRING);
  $public = filter_var($_POST['public'], FILTER_SANITIZE_STRING);

  $sql = "select u_id from Users where u_uname='$user'";
  $result = mysqli_query($link, $sql);

  $row = mysqli_fetch_assoc($result);
  $uid = $row['u_id'];

  $sql = "insert into Boards (u_user_id, title, public) values ('$uid', '$title', '$public')";
  $result = mysqli_query($link, $sql);

  if ($result == 1) {
    $_SESSION['add_board_error'] = "";
    header("Location: board.php?title=$title");
  } else {
    $_SESSION['add_board_error'] = mysqli_error($link);
    header('Location: myboards.php');
  }
?>
