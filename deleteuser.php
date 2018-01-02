<?php
  session_start();

  if (!$_SESSION['allowed'] || !$_SESSION['admin']) {
    header('Location: index.php');
  }

  require_once 'helperscripts/config.inc';

  $userID = $_POST['userID'];
  $isAd = $_POST['isAd'];

  if ($isAd == "No") {
    $sql = "select * from Boards where u_user_id='$userID'";
    $result = mysqli_query($link, $sql);

    if ($result) {
      // delete all of this user's soundboards
      while($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $boardID = $row['u_id'];

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

        if ($result) {
          $_SESSION['delete_board_error'] = "";
        } else {
          $_SESSION['delete_board_error'] = mysqli_error($link);
        }
      }

      // delete the user
      $sql = "delete from Users where u_id='$userID'";
      $result = mysqli_query($link, $sql);

      if ($result) {
        header('Location: admin.php');
      }
    }
  }
  header('Location: admin.php');
?>
