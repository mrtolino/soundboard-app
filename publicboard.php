<?php
session_start();
/*if (!isset($_GET['page']) || !isset($_GET['pageNumber'])) {
  header('Location:index.php?page=all&pageNumber=1');
}

$page = $_GET['page'];
$pageNumber = $_GET['pageNumber'];

if($page != '8' && $page != '12' && $page != '20' && $page != 'all') {
  header('Location:index.php?page=all&pageNumber=1');
} else if ($pageNumber > 100 || $pageNumber < 0) {
  header('Location:index.php?page=all&pageNumber=1');
} else if ($pageNumber == '') {
  header('Location:index.php?page=all&pageNumber=1');
}*/

$uname = isset($_SESSION['user'])?$_SESSION['user']:"visitor";

require_once 'helperscripts/config.inc';

$title = $_GET['title'];
$signup_error = isset($_SESSION['signup_error']) ? $_SESSION['signup_error']:"";
$login_error = isset($_SESSION['signup_error']) ? $_SESSION['login_error']:"";

// logging
$log = "insert into log_baccess (log_boardname, log_username)";
$log .= " values ( '$title', '$uname')";
$res = mysqli_query($link, $log);
if ($res === FALSE) {
  die ("Mysql Error: " . $link->error);
}

if (isset($_SESSION['allowed']) && $_SESSION['allowed']) {
  $controlBtns = "
      <span><p class=\"userControls\"><a href=\"logout.php\">Logout</a></p></span>
      <span><p class=\"userControls\"><a href=\"index.php\">Home</a></p></span>";
} else {

  $controlBtns = "
      <span><p class=\"userControls\" id=\"signup\">Sign Up</p></span>
      <span><p class=\"userControls\" id=\"login\">Login</p></span>
      <span><p class=\"userControls\"><a href=\"index.php\">Home</a></p></span>";
}
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
      .modal {
        max-height: 100%;
        position: fixed;
        background-color: #4ea0ed;
        border-radius: 15px;
        left: 50%;
        top: 50%;
        text-align: center;
        box-shadow: 3px 5px 5px #555;
        padding-right: 20px;
        padding-left: 20px;
      }
      #modal_login {
        transform: translate(-50%, -50%);
      }
      #modal_signup {
        transform: translate(-50%, -50%);
      }
      .modal > .close {
        font-size: 48px;
        float: right;
        cursor: pointer;
      }
      .modal > .close:hover {
        color: #FFF;
      }
      .modal > h1 {
        margin: 20px;
        font-size: 48px;
      }
      .modalForm > input{
        margin: 10px;
        border-radius: 10px;
        border: 2px solid black;
        padding: 5px;
        font-size: 30px;
        cursor: pointer;
      }
      @media screen and (min-width: 1106px) {
        .modal {
          width: 50%;
        }
        .modalForm > input {
          width: 40%;
        }
      }
      @media screen and (min-width: 985px) and (max-width: 1105px) {
        .modal {
          width: 70%;
        }
        .modalForm > input {
          width: 60%;
        }
      }
      @media screen and (min-width: 469px) and (max-width: 984px) {
        .modal {
          width: 80%;
        }
        .modalForm > input {
          width: 50%;
        }
      }
      @media screen and (max-width: 468px) {
        .modal {
          width: 80%;
        }
        .modalForm > input {
          width: 60%;
          font-size: 26px;
        }
      }
      .submit {
        background-color: #999;
      }
      .submit:hover {
        background-color: #589;
      }
      .userControls {
        color: #000;
      }
      .userControls:hover {
        color: #FFF;
      }
    </style>
  </head>
  <body>
  </body>
  </html>

  <body>
    <div class='modal' id='modal_signup' style='display: none;'>
      <span class='close'>&times;</span>
      <h1>Sign Up! It's Free!</h1>
      <form class='modalForm' id='signUpForm' action= 'dosignup.php' method= 'post'>

        <input type= 'text' name= 'fname' placeholder='First name' maxlength= '20' required pattern='[a-zA-Z0-9\s]+'><br>
        <input type= 'text' name= 'lname' placeholder='Last name' maxlength= '30' required pattern='[a-zA-Z0-9\s]+'><br>
        <input type= 'text' name= 'email' placeholder='Email address' maxlength= '40' required><br>
        <input type= 'text' name= 'username' placeholder='Username' maxlength= '20' required pattern='[a-zA-Z0-9\s]+'><br>
        <input type= 'password' name= 'password' placeholder='Password' maxlength= '30' required pattern='[a-zA-Z0-9\s]+'><br>
        <input class='submit' type= 'submit' value= 'Submit'>

        <p id=\"signupErr\">$signup_error</p>
      </form>
    </div>
    <div class='modal' id='modal_login' style='display: none;'>
      <span class='close'>&times;</span>
      <h1>Login</h1>
      <form class='modalForm' id='loginForm' action= 'dologin.php' method= 'post'>
        <input type= 'text' name= 'username' placeholder='Username' maxlength= '20' required pattern='[a-zA-Z0-9\s]+'>
        <input type= 'password' name= 'password' placeholder='Password' maxlength= '30' required pattern='[a-zA-Z0-9\s]+'>
        <input class='submit' type= 'submit' value= 'Log In'>

        <p id=\"loginErr\">$login_error</p>
      </form>
    </div>
    <div id='heading'>
      <p>$title</p>
      $controlBtns
    </div>
    <div id='content'>";
    
     /*<p>
      <button id= 'changeView'>Change the view</button>
      <form id= 'changePage' action= 'publicboard.php' method='get'>
        <input type= 'hidden' name= 'title' value= \"$title\">
        <select id= 'choosePage' name= 'page'>
          <option value= 'all' "; if ($page == 'all') {echo "selected";} echo ">All</option>
          <option value= '8' ";   if ($page == '8') {echo "selected";}   echo ">8</option>
          <option value= '12' ";  if ($page == '12') {echo "selected";}  echo ">12</option>
          <option value= '20' ";  if ($page == '20') {echo "selected";}  echo ">20</option>
        </select>
        <input type= 'hidden' name= 'pageNumber' value= '1'>
      </form>
    </p>;*/


//TODO: Consider whether we should check if the user is still the correct user
//      (the board we are selecting is for the user that is currently logged in)?

/*$user = isset($_SESSION['user']) ? $_SESSION['user']:"";
$sql = "select u_id from Users where u_uname='$user'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_assoc($result);
$uid = $row['u_id'];*/

$sql = "select u_id from Boards where title='$title'";
$result = mysqli_query($link, $sql);

if ($result) {
  $row = mysqli_fetch_assoc($result);
  $boardID = $row['u_id'];
}
//TODO: Add error check if result != 1

/*$sql = "select COUNT(u_id) as total from Content where u_board_id='$boardID'";
$result = mysqli_query($link, $sql);
if($result) {
  $row = mysqli_fetch_assoc($result);
  $total = $row['total'];
}

if($page == 'all') {
  $sql = "select * from Content where u_board_id='$boardID'";
}
else if($total > $page) {
  $lowerBound = $page * ($pageNumber - 1);
  $pages = min ($page, $total);
  $sql="select * from Content where u_board_id='$boardID' limit $lowerBound, $pages";

  echo "<form id= 'pageChange' action= 'publicboard.php' method = 'get'>
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
}*/

$sql = "select * from Content where u_board_id='$boardID'";
$result = mysqli_query($link, $sql);

if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $imgFileName = $row['u_img_filename'];
    $soundFileName = $row['u_sound_filename'];

    $imgFileName = "./uploads/".$imgFileName;
    $soundFileName = "./uploads/".$soundFileName;

    echo "<div class='sBoardDiv'
               style='background-size: cover;
               background-image: url(\"fetchimage.php?filename=$imgFileName\");'>
            <audio src=\"fetchaudio.php?filename=$soundFileName\"></audio>
          </div>";
  }
}

$error = isset($_SESSION['add_board_error'])?$_SESSION['add_board_error']:"";

echo "</div>
    <footer>&copy; Shanasahugh 2017</footer>
    <p>$error</p>

    <script type='text/javascript'>
      window.onload = function() {
        var sounds = document.querySelectorAll('#content > div');
        var modal_signup = document.querySelector('#modal_signup');
        var modal_login = document.querySelector('#modal_login');
        var closeButtonSignup = document.querySelector('#modal_signup > .close');
        var closeButtonLogin = document.querySelector('#modal_login > .close');
        var signup = document.querySelector('#signup');
        var login = document.querySelector('#login');
        /*var changeView = document.querySelector('#changeView');
        var changePage = document.querySelector('#changePage');
        var choosePage = document.querySelector('#choosePage');
        var pageChange = document.querySelector('#pageChange');
        var pageNumber = document.querySelector('#pageNumber');
        var prevBtn = document.querySelector('#prev');
        var nextBtn = document.querySelector('#next');*/
        var loginError = document.querySelector('#loginErr');
        var signupError = document.querySelector('#signupErr');

        if (performance.navigation.type == 1) {
          loginError.innerHTML = '';
          signupError.innerHTML = '';
        }

        if (loginError.innerHTML.length > 0) {
          modal_login.style.display = 'block';
        } else if (signupError.innerHTML.length > 0) {
          modal_signup.style.display = 'block';
        } else {
          modal_login.style.display = 'none';
          modal_signup.style.display = 'none';
        }

        /*
        changeView.addEventListener('click', function() {
          //window.location = 'listPubBoard.php?numPage=all&pageNum=1';
          window.location = \"listPubBoard.php?title=$title&page=all&pageNumber=1\";
        });

        choosePage.onchange = function() {
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
        }
        */

        for (var index = 0; index < sounds.length; index++) {
          (function (sound) {
            var audio = sound.querySelector('audio');
            sound.addEventListener('click', function() {
              if (login && signup) {
                  if (!(modal_signup.style.display == 'block') &&
                      !(modal_login.style.display == 'block')) {
                    if (audio.paused) {
                      audio.play();
                      $.get(\"logsound.php?+sound=\"+sound.title, function(data, status){
                        //alert(\"Data: \" + data + \" \\nStatus: \" + status);
                      });
                    } else {
                      audio.pause();
                    }
                  }
                } else {
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
        }

        if (signup) {
          signup.addEventListener('click', function() {
            if (!(modal_login.style.display == 'block')) {
              if (modal_signup.style.display == 'none') {
                modal_signup.style.display = 'block';
              } else {
                modal_signup.style.display = 'none';
              }
            }
          });
          closeButtonSignup.addEventListener('click', function() {
            modal_signup.style.display = 'none';
          });
        }

        if (login) {
          login.addEventListener('click', function() {
            if (!(modal_signup.style.display == 'block')) {
              if (modal_login.style.display == 'none') {
                modal_login.style.display = 'block';
              } else {
                modal_login.style.display = 'none';
              }
            }
          });
          closeButtonLogin.addEventListener('click', function() {
            modal_login.style.display = 'none';
          });
        }
      }
    </script>
  </body>
</html>
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>"
;


?>
