<?php
  session_start();
?>
<!DOCTYPE>
<html>
  <head>
    <meta charset= 'utf-8'>
    <title></title>
  </head>
  <body>
    <form action= 'dologin.php' method= 'post'>
      <label for= 'username'>Username:</label>
      <input type= 'text' name= 'username' id= 'uname' maxlength= '20' required>

      <label for= 'password'>Password:</label>
      <input type= 'password' name= 'password' id= 'pword' maxlength= '30' required>

      <input type= 'submit' value= 'Log In'>

      <p><?= $_SESSION['login_error'] ?></p>
    </form>
  </body>
</html>
