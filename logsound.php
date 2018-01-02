<?php
  session_start();
  $uname = isset($_SESSION['user'])?$_SESSION['user']:"visitor";
  $sound = $_GET['sound'];

  require_once 'helperscripts/config.inc';

  $log = "insert into log_saccess (log_soundfile, log_username)";
  $log .= " values ('$sound', '$uname')";
  echo $log;
  $res = mysqli_query($link, $log);
  if ($res === FALSE) {
    die ("Mysql Error: " . $link->error);
  }
  echo $res;
?>
