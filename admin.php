<?php
  session_start();

  if (!$_SESSION['allowed'] || !$_SESSION['admin']) {
    header('Location: index.php');
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="index.css">
    <style type="text/css">
      #heading {
        background-color: #f23a52;
      }
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

        <p><?= $_SESSION['login_error'] ?></p>
      </form>
    </div>
    <div id="heading">
      <p>Welcome Administrator!</p>
      <?php
        if (isset($_SESSION["allowed"])&&$_SESSION['allowed']) {
          echo "<span><p><a href='logout.php'>Logout</a></p></span>";
          echo "<span><p><a href='myboards.php'>My Boards</a></p></span>";
        } else {
          echo "<span><p class=\"userControls\" id=\"signup\">Sign Up</p></span>
          <span><p class=\"userControls\" id=\"login\">Login</p></span>";
        }
      ?>
    </div>
    <div id="content">
      <?php
        require_once 'helperscripts/config.inc';

        $sql="select * from Users";
        $result = mysqli_query($link, $sql);

        if ($result) {
          while($row=mysqli_fetch_assoc($result)) {
            $userID = $row['u_id'];
            $uName = $row['u_uname'];
            $fName = $row['u_fname'];
            $lName = $row['u_lname'];
            $eMail = $row['u_email'];
            $isAd = $row['u_isadmin'];
            if ($isAd == 0) {
              $isAd = "No";
            } else if ($isAd == 1) {
              $isAd = "Yes";
            }
            echo "<div class='userDiv'>
                    <span>User: $uName</span>
                    <span>Full name: $fName $lName</span>
                    <span>Email address: $eMail</span>
                    <span>Admin? $isAd</span><br>
                    <button class='deleteUserBtn'>Delete This User</button>
                    <form class='deleteUserForm' action='deleteuser.php' method='post'>
                      <input type='hidden' name='userID' value='$userID'>
                      <input type='hidden' name='isAd' value='$isAd'>
                    </form>
                    <form class='userBoardsPage' action='administrateBoards.php' method='get'>
                      <input type='hidden' name='userID' value='$userID'>
                    </form>
                  </div>";
          }
        }
      ?>
    </div>
    <footer>&copy; Shanasahugh 2017</footer>

    <script type="text/javascript">
    window.onload = function() {
      var userDivs = document.querySelectorAll('#content > .userDiv');
      var deleteUserBtns = document.querySelectorAll('#content > .userDiv > .deleteUserBtn');

      for (var index = 0; index < userDivs.length; index++) {
        (function (deleteUserBtn, userDiv) {
          deleteUserBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDiv.querySelector('.deleteUserForm').submit();
          });
        })(deleteUserBtns[index], userDivs[index]);
        (function (userDiv) {
          userDiv.addEventListener('click', function() {
            this.querySelector('.userBoardsPage').submit();
          });
        })(userDivs[index]);
      }
    };
    </script>
  </body>
</html>
