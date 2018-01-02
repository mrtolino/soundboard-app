<?php
  session_start();
  $u_uname_input = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $u_pword_input = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
  $u_pword_input = hash("sha256", $u_uname_input."shanasahughAmazinGGGsalt".$u_pword_input);

  require_once 'helperscripts/config.inc';

  $stmt = $link->prepare("select u_pword from Users where u_uname = ?");
  if ($stmt === FALSE) {
    die ("Mysql Error: " . $link->error);
  }
  $stmt->bind_param('s', $u_uname_input);
  $stmt->execute();

  $stmt->bind_result($pword);
  $stmt->fetch();
  $stmt->close();

/*  $sql = "select u_pword from Users where u_uname="."\"$u_uname_input\"".";";
  $result = mysqli_query($link, $sql);

  while($row = mysqli_fetch_assoc($result)) {
    $pword = $row['u_pword'];
  }
*/
  if($u_pword_input == $pword) {
    $_SESSION['allowed'] = true;
    $_SESSION['login_error'] = '';
    $_SESSION['user'] = $u_uname_input;

    $sql = "select u_isadmin from Users where u_uname='$u_uname_input'";
    $result = mysqli_query($link, $sql);

    if ($result) {
      $row = mysqli_fetch_assoc($result);
      $isAdmin = $row['u_isadmin'];

      if ($isAdmin == 1) {
        $_SESSION['admin'] = true;
      } else {
        $_SESSION['admin'] = false;
      }
    }

    $log = "insert into log_login (log_uname, log_inout, log_issuccessful)";
    $log .= " values ( '$u_uname_input', 1, 1)";
    $res = mysqli_query($link, $log);
    if ($res === FALSE) {
      die ("Mysql Error: " . $link->error);
    }

    header('Location: myboards.php');
  }
  else {
    $_SESSION['login_error'] = "The password you've entered is incorrect.";
    $log = "insert into log_login (log_uname, log_inout, log_issuccessful)";
    $log .= " values ( '$u_uname_input', 1, 0)";
    $res = mysqli_query($link, $log);
    if ($res === FALSE) {
      die ("Mysql Error: " . $link->error);
    }
    header('Location: index.php');
  }
?>
