<?php
  session_start();
?>
<!DOCTYPE>
<html>
  <head>
    <meta charset='utf-8'>
    <title>Sign Up!</title>
  </head>
  <body>
    <form id="signUpForm" action= 'dosignup.php' method= 'post'>

      <label for= 'fname'>First Name:</label>
      <input type= 'text' name= 'fname' maxlength= '20' required><br>

      <label for= 'lname'>Last Name:</label>
      <input type= 'text' name= 'lname' maxlength= '30' required><br>

      <label for= 'email'>Email Address:</label>
      <input type= 'text' name= 'email' maxlength= '40' required><br>

      <label for= 'username'>Username:</label>
      <input type= 'text' name= 'username' maxlength= '20' required><br>

      <label for= 'password'>Password:</label>
      <input type= 'password' name= 'password' maxlength= '30' required><br>

      <input type= 'submit' value= 'Submit'>

      <p><?= $_SESSION['signup_error'] ?></p>
    </form>
  </body>
</html>
