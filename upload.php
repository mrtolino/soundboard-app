<?php
  session_start();
  if (!$_SESSION['allowed']) {
    header("Location: index.php");
  }

  require_once 'helperscripts/config.inc';

  try {
    $retValImg = 0;
    $retValSound = 0;
    $title = isset($_POST['title'])?$_POST['title']:0;

    if ($_FILES['image']['size'] > 0) {
      uploadImage($retValImg);
    }
    if ($_FILES['sound']['size'] > 0) {
      uploadSound($retValSound);
    }

    $sql = "select u_id from Boards where title='$title'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $uid = $row['u_id'];


    if ($retValImg && $retValSound) {

      $sql = "insert into Content (u_board_id, u_img_filename, u_sound_filename) values ('$uid', '$retValImg', '$retValSound')";
      $result = mysqli_query($link, $sql);

      if ($result == 1) {
        $_SESSION['add_board_error'] = "";
      } else {
        $_SESSION['add_board_error'] = "Problem encountered while attempting to upload sound and image.";
      }
    } else if (!$retValImg && $retValSound) {
      $sql = "insert into Content (u_board_id, u_img_filename, u_sound_filename) values ('$uid', '', '$retValSound')";
      $result = mysqli_query($link, $sql);

      if ($result == 1) {
        $_SESSION['add_board_error'] = "";
      } else {
        $_SESSION['add_board_error'] = "Problem encountered while attempting to upload sound.";
      }
    } else if ($retValImg && !$retValSound) {
      $sql = "insert into Content (u_board_id, u_img_filename, u_sound_filename) values ('$uid', '$retValImg', '')";
      $result = mysqli_query($link, $sql);

      if ($result == 1) {
        $_SESSION['add_board_error'] = "";
      } else {
        $_SESSION['add_board_error'] = "Problem encountered while attempting to upload image.";
      }
    }
    header("Location: board.php?title=$title&page=all&pageNumber=1");
  } catch(RuntimeException $e) {
    //echo $e->getMessage();
  }


  function uploadImage(&$retValImg) {
    try {
      // Check $_FILES['image']['error'] value.
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

      // You should also check filesize here.
      if ($_FILES['image']['size'] > 100000000) {
          throw new RuntimeException('Exceeded image file size limit.');
      }

      // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
      // Check MIME Type by yourself.

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

      // You should name it uniquely.
      // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
      // On this example, obtain safe unique name from its binary data.
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
      // Check $_FILES['sound']['error'] value.
      switch ($_FILES['sound']['error']) {
          case UPLOAD_ERR_OK:
              break;
          case UPLOAD_ERR_NO_FILE:
              return 0;
              //throw new RuntimeException('No sound file sent.');
          case UPLOAD_ERR_INI_SIZE:
          case UPLOAD_ERR_FORM_SIZE:
              throw new RuntimeException('Exceeded sound file size limit.');
          default:
              throw new RuntimeException('Unknown errors.');
      }

      // You should also check filesize here.
      if ($_FILES['sound']['size'] > 100000000) {
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
