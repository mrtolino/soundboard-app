<?php
  session_start();
  if (!$_SESSION['allowed']) {
    header('Location: index.php');
  }

  require_once 'helperscripts/config.inc';

  $title = filter_var($_POST['title'], FILTER_SANITIZE_VAR);
  $boardID = filter_var($_POST['boardID'], FILTER_SANITIZE_VAR);
  $iFileName = $_POST['imgFileName'];
  $sFileName = $_POST['soundFileName'];

  // Delete images from filesystem
  unlink('./uploads/'.$iFileName);

  //Delete sounds from filesystem
  unlink('./uploads/'.$sFileName);

  //delete contents of the sound from the board
  $sql = "delete from Content where u_board_id = '$boardID' and u_img_filename='$iFileName' and u_sound_filename='$sFileName'";
  $result = mysqli_query($link, $sql);

  if ($result == 1) {
    $_SESSION['delete_sound_error'] = "";
  } else {
    $_SESSION['delete_sound_error'] = "There was a problem encountered while attempting to delete this sound.";
  }

  header("Location: board.php?title=$title");
?>
