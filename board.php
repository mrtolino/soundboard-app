<?php
  session_start();
  if(!$_SESSION['allowed']) {
    header('Location: index.php');
  }
  /*if (!isset($_GET['page']) || !isset($_GET['pageNumber'])) {
    header('Location:myboards.php?page=all&pageNumber=1');
  }

  $page = $_GET['page'];
  $pageNumber = $_GET['pageNumber'];

  if($page != '8' && $page != '12' && $page != '20' && $page != 'all') {
    header('Location:myboards.php?page=all&pageNumber=1');
  } else if ($pageNumber > 100 || $pageNumber < 0) {
    header('Location:myboards.php?page=all&pageNumber=1');
  } else if ($pageNumber == '') {
    header('Location:myboards.php?page=all&pageNumber=1');
  }
  */
  require_once 'helperscripts/config.inc';

  $title = filter_var($_GET['title'], FILTER_SANITIZE_STRING);

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
          </style>
        </head>
        <body>
          <div id='heading'>
            <p>$title</p>
            <span><p><a href='logout.php'>Logout</a></p></span>
            <span><p><a href='myboards.php'>My Boards</a></p></span>
          </div>
          <div id='content'>
            <!-- <div id= 'responseOutput'></div> -->
          <!--<p>
            <button id= 'changeView'>Change the view</button>
            <form id= 'changePage' action= 'board.php' method='get'>
              <input type= 'hidden' name= 'title' value= \"$title\">
              <select id= 'choosePage' name= 'page'>
                <option value= 'all' "; if ($page == 'all') {echo "selected";} echo ">All</option>
                <option value= '8' ";   if ($page == '8') {echo "selected";}   echo ">8</option>
                <option value= '12' ";  if ($page == '12') {echo "selected";}  echo ">12</option>
                <option value= '20' ";  if ($page == '20') {echo "selected";}  echo ">20</option>
              </select>
              <input type= 'hidden' name= 'pageNumber' value= '1'>
            </form>
          </p>-->";
    } else {
      $_SESSION['board_error'] = 'Board not found.';
      header('Location: myboards.php');
    }
    //TODO: Complete the above error check
  } else {

  }
  //TODO: Add error check if result != 1

  // Count how many contents of the board there are for pagination
  /*
  $sql = "select COUNT(u_id) as total from Content where u_board_id='$boardID'";
  $result = mysqli_query($link, $sql);
  if($result) {
    $row = mysqli_fetch_assoc($result);
    $total = $row['total'];
  }

  // Depend on the page(5, 10, 20, all) that user choose, diplay the same number of contents
  if($page == 'all') {
    $sql = "select * from Content where u_board_id='$boardID'";
  }
  else if($total > $page) {
    $lowerBound = $page * ($pageNumber - 1);
    $pages = min ($page, $total);
    $sql="select * from Content where u_board_id='$boardID' limit $lowerBound, $pages";

    echo "<form id= 'pageChange' action= 'board.php' method = 'get'>
            <input type= 'hidden' name= 'title' value= \"$title\">
            <input type = 'hidden' name= 'page' value = $page>
            <input id = 'pageNumber' type= 'hidden' name= 'pageNumber'>";
    if($lowerBound == 0) {
       echo"<button id = 'prev' style= 'visibility: hidden'>Prev</button>";
       echo"<button id = 'next' style = 'visibility: visible'>Next</button>";
    } else if($upperBound == $total || $total - ($page * ($pageNumber - 1)) < $page) {
       echo"<button id = 'prev' style = 'visibility: visible'>Prev</button>";
       echo"<button id = 'next' style= 'visibility: hidden'>Next</button>";
    } else {
       echo"<button id = 'prev' style = 'visibility: visible'>Prev</button>";
       echo"<button id = 'next' style= 'visibility: visible'>Next</button>";
    }
    echo "</form>";
  }
  else if($total <= $page) {
    $sql = "select * from Content where u_board_id='$boardID'";
  }
  */

  $sql = "select * from Content where u_board_id='$boardID'";
  $result = mysqli_query($link, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $imgFileName = $row['u_img_filename'];
      $soundFileName = $row['u_sound_filename'];

      $imgFileNamePath = "./uploads/".$imgFileName;
      $soundFileNamePath = "./uploads/".$soundFileName;

      echo "<div class='soundDiv sBoardDiv'
                 style='background-size: cover;
                 background-image: url(\"fetchimage.php?filename=$imgFileNamePath\");'>
              <audio src=\"fetchaudio.php?filename=$soundFileNamePath\"></audio>
              <form class='changeSoundForm' style='display: none;' action='editSound.php' method='post' enctype='multipart/form-data'>
                <label>Update sound: </label>
                <input type='file' name='sound'><br>
                <label>Update image: </label>
                <input type='file' name='image'><br>
                <input type='hidden' name='title' value='$title'>
                <input type='hidden' name='boardID' value='$boardID'>
                <input type='hidden' name='imgFileName' value='$imgFileName'>
                <input type='hidden' name='soundFileName' value='$soundFileName'>
                <input type='submit' value='Submit'>
              </form>
              <form class='deleteSoundForm' action='deletesound.php' method='post'>
                <input type='hidden' name='title' value='$title'>
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
            <p>Maximum file size 2M </p>
            <label>Upload a sound: </label>
            <input type='file' accept=\".mp3, .mp4, .aif, .wav\" name='sound'><br>
            <label>Upload an image: </label>
            <input type='file' accept=\".jpg, .gif, .png\" name='image'><br>
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
          /*var changeView = document.querySelector('#changeView');
          var changePage = document.querySelector('#changePage');
          var choosePage = document.querySelector('#choosePage');
          var pageChange = document.querySelector('#pageChange');
          var pageNumber = document.querySelector('#pageNumber');
          var prevBtn = document.querySelector('#prev');
          var nextBtn = document.querySelector('#next');
          var isListView = true;*/

          // change between grid view and list view
          /*changeView.addEventListener('click', function() {
            window.location = \"listBoard.php?title=$title&page=all&pageNumber=1\";
            for (var index = 0; index < sounds.length; index++) {
                if (isListView == true) {
                   sounds[index].style.display = 'block';
                   sounds[index].style.margin = '20px auto';
                   sounds[index].style.height = '120px';
                   //sendRequest();
                }
                else {
                  sounds[index].style.display = 'inline-block';
                  sounds[index].style.margin = '';
                  sounds[index].style.height = '300px';
                }
            }
            isListView = !isListView;
          });*/

          // submit form based on the page input (8, 12, 20, all)
          /*choosePage.onchange = function() {
            changePage.submit();
          };

          if(prevBtn) {
            prevBtn.addEventListener('click', function() {
              pageNumber.value = $pageNumber-1;
              pageChange.submit();
            });
          }

          if(nextBtn) {
            nextBtn.addEventListener('click', function() {
              pageNumber.value = $pageNumber+1;
              pageChange.submit();
            });
          }*/

          for (var index = 0; index < sounds.length-1; index++) {

              (function (sound) {
                var audio = sound.querySelector('audio');
                sound.addEventListener('click', function() {
                  if (sound.style.backgroundSize == 'cover') {
                    if (audio.paused) {
                      audio.play();
                      $.get(\"logsound.php?+sound=\"+sound.title, function(data, status){
                        //alert(\"Data: \" + data + \" \\nStatus: \" + status);
                      });
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
  </html>
  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>";

?>
