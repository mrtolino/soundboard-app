<?php
  session_start();
  if (!$_SESSION['allowed']) {
    header('Location: index.php');
  }

  require_once 'helperscripts/config.inc';

  $user = $_SESSION['user'];
  $title = filter_var($_GET['title'], FILTER_SANITIZE_VAR);

  // Get board id from Boards table
  $sql = "select u_id from Boards where title = '$title'";
  $result = mysqli_query($link, $sql);

  if ($result == 1) {
    $row = mysqli_fetch_assoc($result);
    $boardID = $row['u_id'];
  }

  // Delete images from filesystem
  $sql = "select u_img_filename from Content where u_board_id = '$boardID'";
  $result = mysqli_query($link, $sql);

  if ($result == 1) {
    while($row = mysqli_fetch_assoc($result)) {
      $delete_img = $row['u_img_filename'];
      unlink('./uploads/'.$delete_img);
    }
  }

  //Delete sounds from filesystem
  $sql = "select u_sound_filename from Content where u_board_id = '$boardID'";
  $result = mysqli_query($link, $sql);
  while($row = mysqli_fetch_assoc($result)) {
    $delete_sound = $row['u_sound_filename'];
    unlink('./uploads/'.$delete_sound);
  }

  //delete contents of the board
  $sql = "delete from Contents where u_board_id = '$boardID'";
  $result = mysqli_query($link, $sql);

  //delete the board
  $sql = "delete from Boards where u_id = '$boardID'";
  $result = mysqli_query($link, $sql);

  if ($result == 1) {
    $_SESSION['delete_board_error'] = "";
  } else {
    $_SESSION['delete_board_error'] = mysqli_error($link);
  }

  header('Location: myboards.php');

?>
