<?php
  session_start();
  $uname = $_SESSION['user'];

  require_once 'helperscripts/config.inc';

  $log = "insert into log_login (log_uname, log_inout, log_issuccessful)";
  $log .= " values ( '$uname', 0, 1)";
  $res = mysqli_query($link, $log);
  if ($res === FALSE) {
    die ("Mysql Error: " . $link->error);
  }
  session_destroy();
  header("Location: index.php");
?>
