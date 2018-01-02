<?php
  session_start();

  if (!isset($_GET['page']) || !isset($_GET['pageNumber'])) {
    header('Location:listIndex.php?page=all&pageNumber=1');
  }

  $page = $_GET['page'];
  $pageNumber = $_GET['pageNumber'];

  if($page != '5' && $page != '10' && $page != '20' && $page != 'all') {
    header('Location:listIndex.php?page=all&pageNumber=1');
  } else if ($pageNumber > 100 || $pageNumber < 0) {
    header('Location:listIndex.php?page=all&pageNumber=1');
  } else if ($pageNumber == '') {
    header('Location:listIndex.php?page=all&pageNumber=1');
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shanasahugh Soundboard</title>
    <link rel="stylesheet" href="index.css">
    <style type="text/css">
      #content > div {
        height: 120px;
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
      .modalForm > input {
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
      .boardTitle {
        font-size: 26px;
      }

    </style>
  </head>
  <body>
    <div class="modal" id="modal_signup" style='display: none;'>
      <span class="close">&times;</span>
      <h1>Sign Up! It's Free!</h1>
      <form class="modalForm" id="signUpForm" action= 'dosignup.php' method= 'post'>

        <input type= 'text' name= 'fname' placeholder="First name" maxlength= '20' required><br>
        <input type= 'text' name= 'lname' placeholder="Last name" maxlength= '30' required><br>
        <input type= 'text' name= 'email' placeholder="Email address" maxlength= '40' required><br>
        <input type= 'text' name= 'username' placeholder="Username" maxlength= '20' required><br>
        <input type= 'password' name= 'password' placeholder="Password" maxlength= '30' required><br>
        <input class="submit" type= 'submit' value= 'Submit'>

        <p><?= isset($_SESSION['signup_error'])?$_SESSION['signup_error']:"" ?></p>
      </form>
    </div>
    <div class="modal" id="modal_login" style='display: none;'>
      <span class="close">&times;</span>
      <h1>Login</h1>
      <form class="modalForm" id="loginForm" action= 'dologin.php' method= 'post'>
        <input type= 'text' name= 'username' placeholder="Username" maxlength= '20' required>
        <input type= 'password' name= 'password' placeholder="Password" maxlength= '30' required>
        <input class="submit" type= 'submit' value= 'Log In'>

        <p><?= isset($_SESSION['login_error'])? $_SESSION['login_error']:"" ?></p>
      </form>
    </div>
    <div id="heading">
      <p>Shanasahugh Soundboards</p>
      <?php
        if (isset($_SESSION["allowed"])&&$_SESSION['allowed']) {
          echo "<span><p><a href='logout.php'>Logout</a></p></span>";
          echo "<span><p><a href='myboards.php?page=all&pageNumber=1'>My Boards</a></p></span>";
        } else {
          echo "<span><p class=\"userControls\" id=\"signup\">Sign Up</p></span>
          <span><p class=\"userControls\" id=\"login\">Login</p></span>";
        }
      ?>
    </div>
    <div id="content">
      <?php
      echo "
      <p>
        <button id= 'changeView'>Change the view</button>
        <form id= 'changePage' action= 'listIndex.php' method='get'>
          <select id= 'choosePage' name= 'page'>
            <option value= 'all' "; if ($page == 'all') {echo "selected";} echo ">All</option>
            <option value= '5' ";   if ($page == '5') {echo "selected";}   echo ">5</option>
            <option value= '10' ";  if ($page == '10') {echo "selected";}  echo ">10</option>
            <option value= '20' ";  if ($page == '20') {echo "selected";}  echo ">20</option>
          </select>
          <input type= 'hidden' name= 'pageNumber' value= '1'>
        </form>
      </p>";
        require_once 'helperscripts/config.inc';

        $sql = "select COUNT(title) as total from boards where public= '1'";
        $result = mysqli_query($link, $sql);
        if($result) {
          $row = mysqli_fetch_assoc($result);
          $total = $row['total'];
        }

        if($page == 'all') {
          $sql="select title from Boards where public = '1'";
        }
        else if($total > $page) {
          $lowerBound = $page * ($pageNumber - 1);
          $pages = min ($page, $total);
          $sql="select title from Boards where public = '1' limit $lowerBound, $pages";
          echo "<form id= 'pageChange' action= 'listIndex.php' method = 'get'>
                  <input type = 'hidden' name= 'page' value = $page>
                  <input id = 'pageNumber' type= 'hidden' name= 'pageNumber'>";
          if($lowerBound == 0) {
             echo"<button id = 'prev' style= 'visibility: hidden'>Prev</button>";
             echo"<button id = 'next' style = 'visibility: visible'>Next</button>";
          }
           else if($upperBound == $total || $total - ($page * ($pageNumber - 1)) < $page) {
             echo"<button id = 'prev' style = 'visibility: visible'>Prev</button>";
             echo"<button id = 'next' style= 'visibility: hidden'>Next</button>";
          } else {
            echo"<button id = 'prev' style = 'visibility: visible'>Prev</button>";
            echo"<button id = 'next' style= 'visibility: visible'>Next</button>";
          }
          echo"</form>";
        }
        else if($total <= $page) {
          $sql="select title from Boards where public = '1'";
        }

        $result = mysqli_query($link, $sql);

        if ($result) {
          while($row=mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            echo "<div class='sBoardDiv' style = 'display: block; margin: 20px auto;'>
                    <p class='boardTitle'>$title</p>
                    <form action='publicboard.php' method='get'>
                      <input type='hidden' name='title' value='$title'>
                      <input type='hidden' name='page' value='all'>
                      <input type='hidden' name='pageNumber' value='1'>
                    </form>
                  </div>";
          }
        }
      ?>
    </div>
    <footer>&copy; Shanasahugh 2017</footer>

    <script type="text/javascript">
    window.onload = function() {
      var boards = document.querySelectorAll('#content > div');
      var modal_signup = document.querySelector('#modal_signup');
      var modal_login = document.querySelector('#modal_login');
      var closeButtonSignup = document.querySelector('#modal_signup > .close');
      var closeButtonLogin = document.querySelector('#modal_login > .close');
      var signup = document.querySelector('#signup');
      var login = document.querySelector('#login');
      var changeView = document.querySelector('#changeView');
      var changePage = document.querySelector('#changePage');
      var choosePage = document.querySelector('#choosePage');
      var pageChange = document.querySelector('#pageChange');
      var pageNumber = document.querySelector('#pageNumber');
      var prevBtn = document.querySelector('#prev');
      var nextBtn = document.querySelector('#next');

      changeView.addEventListener('click', function() {
        window.location = 'index.php?page=all&pageNumber=1';
      });

      choosePage.onchange = function() {
        changePage.submit();
      };

      <?php
      echo "
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
      }";
      ?>

      for (var index = 0; index < boards.length; index++) {
        boards[index].addEventListener('click', function() {
          if (login && signup) {
            if (!(modal_signup.style.display == 'block') &&
              !(modal_login.style.display == 'block')) {
                this.querySelector('form').submit();
            }
          } else {
            this.querySelector('form').submit();
          }
        });
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
    };
    </script>
  </body>
</html>
