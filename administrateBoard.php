<?php
  session_start();
  if(!$_SESSION['allowed'] || !$_SESSION['admin']) {
    header('Location: index.php');
  }

  require_once 'helperscripts/config.inc';

  $title = filter_var($_GET['title'], FILTER_SANITIZE_STRING);
  $userID = filter_var($_GET['userID'], FILTER_SANITIZE_STRING);

  //TODO: Consider whether we should check if the user is still the correct user
  //      (the board we are selecting is for the user that is currently logged in)?

  $sql = "select u_id from Boards where title='$title'";
  $result = mysqli_query($link, $sql);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $boardID = $row['u_id'];

    //if the title exists, then setup the HTML page
    if ($boardID) {
      echo "<!DOCTYPE html>
      <html>
        <head>
          <meta charset='utf-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1'>
          <title>$title</title>
          <link rel='stylesheet' href='index.css'>
          <style type='text/css'>
            #content > div {
              height: 300px;
            }
            .soundDiv {
              position: relative;
            }
            .soundDiv > .editBtn {
              position: absolute;
              bottom: 10px;
              right: 10px;
            }
            .soundDiv > .deleteBtn {
              position: absolute;
              bottom: 10px;
              left: 10px;
            }
            #heading {
              background-color: #f23a52;
            }
          </style>
        </head>
        <body>
          <div id='heading'>
            <p>$title</p>
            <span><p><a href='logout.php'>Logout</a></p></span>
            <span><p><a href='administrateBoards.php?userID=$userID'>Administrate Boards</a></p></span>
          </div>
          <div id='content'>";
    } else {
      $_SESSION['board_error'] = 'Board not found.';
      header('Location: myboards.php');
    }
    //TODO: Complete the above error check
  } else {

  }
  //TODO: Add error check if result != 1

  $sql = "select * from Content where u_board_id='$boardID'";
  $result = mysqli_query($link, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $imgFileName = $row['u_img_filename'];
      $soundFileName = $row['u_sound_filename'];

      $imgFileNamePath = "./uploads/".$imgFileName;
      $soundFileNamePath = "./uploads/".$soundFileName;

      echo "<div class='soundDiv sBoardDiv' style='background-size: cover; background-image: url(\"fetchimage.php?filename=$imgFileNamePath\");'>
              <audio src=\"fetchaudio.php?filename=$soundFileNamePath\"></audio>
              <form class='changeSoundForm' style='display: none;' action='editSound.php' method='post' enctype='multipart/form-data'>
                <label>Update sound: </label>
                <input type='file' name='sound'><br>
                <label>Update image: </label>
                <input type='file' name='image'><br>
                <input type='hidden' name='title' value='$title'pattern='[a-zA-Z0-9\s]+'>
                <input type='hidden' name='boardID' value='$boardID'pattern='[a-zA-Z0-9\s]+'>
                <input type='hidden' name='imgFileName' value='$imgFileName'>
                <input type='hidden' name='soundFileName' value='$soundFileName'>
                <input type='submit' value='Submit'>
              </form>
              <form class='deleteSoundForm' action='deletesound.php' method='post'>
                <input type='hidden' name='title' value='$title'pattern='[a-zA-Z0-9\s]+'>
                <input type='hidden' name='boardID' value='$boardID'>
                <input type='hidden' name='imgFileName' value='$imgFileName'>
                <input type='hidden' name='soundFileName' value='$soundFileName'>
              </form>
              <button class='deleteBtn' style='display: none;'>Delete</button>
              <button class='editBtn'>Edit</button>
            </div>";
    }
  }

  $error_update = isset($_SESSION['update_board_error'])?
    $_SESSION['update_board_error']:"";
  $error_delete = isset($_SESSION['delete_board_error'])?
    $_SESSION['delete_board_error']:"";

  echo "<div id='createSound'>
          <p>Add Sound</p>
          <form id='addSound' action='upload.php' method='post' enctype='multipart/form-data'>
            <label>Upload a sound: </label>
            <input type='file' name='sound'><br>
            <label>Upload an image: </label>
            <input type='file' name='image'><br>
            <input type='hidden' name='title' value='$title'>
            <input type='submit' value='Submit'>
          </form>
        </div>
      </div>
      <footer>&copy; Shanasahugh 2017</footer>
      <p>$error_update</p>
      <p>$error_delete</p>

      <script type='text/javascript'>
        window.onload = function() {
          var sounds = document.querySelectorAll('#content > div');
          var editBtns = document.querySelectorAll('#content > div > .editBtn');
          var deleteBtns = document.querySelectorAll('#content > div > .deleteBtn');
          var changeSoundForms = document.querySelectorAll('#content > div > .changeSoundForm');
          var deleteSoundForms = document.querySelectorAll('#content > div > .deleteSoundForm');

          for (var index = 0; index < sounds.length-1; index++) {
              (function (sound) {
                var audio = sound.querySelector('audio');
                sound.addEventListener('click', function() {
                  if (sound.style.backgroundSize == 'cover') {
                    if (audio.paused) {
                      audio.play();
                    } else {
                      audio.pause();
                    }
                  }
                });
              })(sounds[index]);

              (function (editBtn, sound, deleteBtn, changeSoundForm, deleteSoundForm) {
                editBtn.addEventListener('click', function(e) {
                  e.stopPropagation();
                  if (sound.style.backgroundSize == 'cover') {
                    sound.style.backgroundSize = '0 0';
                    deleteBtn.style.display = '';
                    changeSoundForm.style.display = '';
                  } else {
                    sound.style.backgroundSize = 'cover';
                    deleteBtn.style.display = 'none';
                    changeSoundForm.style.display = 'none';
                  }
                });
                deleteBtn.addEventListener('click', function() {
                  deleteSoundForm.submit();
                });
              })(editBtns[index], sounds[index], deleteBtns[index], changeSoundForms[index], deleteSoundForms[index]);
          }
        }
      </script>
    </body>
  </html>";

?>
