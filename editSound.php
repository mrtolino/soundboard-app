<?php
  session_start();
  if (!$_SESSION['allowed']) {
    header("Location: index.php");
  }

  require_once 'helperscripts/config.inc';

  $boardID = $_POST['boardID'];
  $iFileName = $_POST['imgFileName'];
  $sFileName = $_POST['soundFileName'];

  try {
    $retValImg = 0;
    $retValSound = 0;
    $title = $_POST['title'];

    if (($_FILES['image']['size'] == 0 && $_FILES['sound']['size'] == 0) ||
      is_array($_FILES['image']['error']) || is_array($_FILES['sound']['error'])) {
      throw new RuntimeException('Invalid parameters.');
    }
    if ($_FILES['image']['size'] > 0) {
      uploadImage($retValImg);
    }
    if ($_FILES['sound']['size'] > 0) {
      uploadSound($retValSound);
    }

    if ($retValImg && $retValSound) {
      $sql = "update Content set u_img_filename='$retValImg', u_sound_filename='$retValSound'
              where u_board_id='$boardID' and u_img_filename='$iFileName' and u_sound_filename='$sFileName'";
      $result = mysqli_query($link, $sql);

      if ($result == 1) {
        unlink('./uploads/'.$iFileName);
        unlink('./uploads/'.$sFileName);
        $_SESSION['update_board_error'] = "";
      } else {
        $_SESSION['update_board_error'] = "Problem encountered while attempting to update image and sound.";
      }
    } else if (!$retValImg && $retValSound) {
      $sql = "update Content set u_sound_filename='$retValSound'
              where u_board_id='$boardID' and u_img_filename='$iFileName' and u_sound_filename='$sFileName'";
      $result = mysqli_query($link, $sql);

      if ($result == 1) {
        unlink('./uploads/'.$sFileName);
        $_SESSION['update_board_error'] = "";
      } else {
        $_SESSION['update_board_error'] = "Problem encountered while attempting to update sound.";
      }
    } else if ($retValImg && !$retValSound) {
      $sql = "update Content set u_img_filename='$retValImg'
              where u_board_id='$boardID' and u_img_filename='$iFileName' and u_sound_filename='$sFileName'";
      $result = mysqli_query($link, $sql);

      if ($result == 1) {
        unlink('./uploads/'.$iFileName);
        $_SESSION['update_board_error'] = "";
      } else {
        $_SESSION['update_board_error'] = "Problem encountered while attempting to update image.";
      }
    }

    header("Location: board.php?title=$title&page=all&pageNumber=1");

  } catch(RuntimeException $e) {
    //echo $e->getMessage();
  }

  function uploadImage(&$retValImg) {
    try {
      switch ($_FILES['image']['error']) {
          case UPLOAD_ERR_OK:
              break;
          case UPLOAD_ERR_NO_FILE:
              return 0;//throw new RuntimeException('No image file sent.');
          case UPLOAD_ERR_INI_SIZE:
          case UPLOAD_ERR_FORM_SIZE:
              throw new RuntimeException('Exceeded image file size limit.');
          default:
              throw new RuntimeException('Unknown errors.');
      }

      if ($_FILES['image']['size'] > 1000000) {
          throw new RuntimeException('Exceeded image file size limit.');
      }

      //TODO: Add more accepted image file formats
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      if (false === $extImg = array_search(
          $finfo->file($_FILES['image']['tmp_name']),
          array(
              'jpg' => 'image/jpeg',
              'png' => 'image/png',
              'gif' => 'image/gif'
          ),
          true
      )) {
          throw new RuntimeException('Invalid image file format.');
      }

      $imageFileName = hash("sha1", $_SESSION['user'].$_FILES['image']['tmp_name']);

      //TODO: Check if file name exists in database; if it does, delete it and then insert new file with same name.

      if (!move_uploaded_file($_FILES['image']['tmp_name'], sprintf('./uploads/%s.%s', $imageFileName, $extImg))) {
          throw new RuntimeException('Failed to move image file.');
      }

      $imageFileName .= ".".$extImg;

      $retValImg = $imageFileName;
    } catch (RuntimeException $e) {
      $retValImg = 0;
    }
  }

  function uploadSound(&$retValSound) {
    try {
      switch ($_FILES['sound']['error']) {
          case UPLOAD_ERR_OK:
              break;
          case UPLOAD_ERR_NO_FILE:
              return 0;//throw new RuntimeException('No sound file sent.');
          case UPLOAD_ERR_INI_SIZE:
          case UPLOAD_ERR_FORM_SIZE:
              throw new RuntimeException('Exceeded sound file size limit.');
          default:
              throw new RuntimeException('Unknown errors.');
      }

      if ($_FILES['sound']['size'] > 1000000) {
          throw new RuntimeException('Exceeded sound file size limit.');
      }

      //TODO: Add more accepted audio file formats
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      if (false === $extSound = array_search(
          $finfo->file($_FILES['sound']['tmp_name']),
          array(
              'mp3'       => 'audio/mpeg',
              'mp4 audio' => 'audio/mp4',
              'aif'       => 'audio/x-aiff',
              'wav'       => 'audio/x-wav'
          ),
          true
      )) {
          throw new RuntimeException('Invalid sound file format.');
      }

      $soundFileName = hash("sha1", $_SESSION['user'].$_FILES['sound']['tmp_name']);

      if (!move_uploaded_file($_FILES['sound']['tmp_name'], sprintf('./uploads/%s.%s', $soundFileName, $extSound))) {
          throw new RuntimeException('Failed to move sound file.');
      }

      $soundFileName .= ".".$extSound;

      $retValSound = $soundFileName;
    } catch (RuntimeException $e) {
      $retValSound = 0;
    }
  }
?>
