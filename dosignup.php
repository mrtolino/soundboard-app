<?php
  session_start();
  $u_fname_input = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
  $u_lname_input = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
  $u_email_input = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
  $u_uname_input = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $u_pword_input = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
  $u_is_admin = 0;
  
  if (filter_var($u_email_input, FILTER_VALIDATE_EMAIL)){
	  require_once 'helperscripts/config.inc';

	  $u_pword_input = hash("sha256", $u_uname_input."shanasahughAmazinGGGsalt".$u_pword_input);

	  $stmt = $link->prepare("insert into Users (u_uname, u_pword, u_fname, u_lname,
	   u_email, u_isadmin) values (?, ?, ?, ?, ?, ?)");
	  if ($stmt === FALSE) {
		die ("Mysql Error: " . $link->error);
	  }
	  $stmt->bind_param('sssssi', $u_uname_input, $u_pword_input, $u_fname_input,
		$u_lname_input, $u_email_input, $u_is_admin);
	  $result = $stmt->execute();

	  echo "$stmt->affected_rows";


	  /*$sql = "insert into Users (u_uname, u_pword, u_fname, u_lname, u_email, u_isadmin)";
	  $sql .= " values ('$u_uname_input', '$u_pword_input', '$u_fname_input', '$u_lname_input', '$u_email_input', '0')";
	  $result = mysqli_query($link, $sql);*/

	  if ($result) {
		//echo "SUCCESS";
		$_SESSION['signup_error'] = "";
		$_SESSION['user'] = $u_uname_input;
		$_SESSION['allowed'] = true;
		$stmt->close();
		header('Location: myboards.php');
	  } else {
		//echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		$error = mysqli_error($link);
		$error = explode(" ", $error);
		$_SESSION['signup_error'] = $error[count($error)-1];
		if ($error[count($error)-1] == '\'uname\'') {
		  $_SESSION['signup_error'] = "Please pick a different username!";
		} else if ($error[count($error)-1] == '\'u_email\'') {
		  $_SESSION['signup_error'] = "The email you've entered is already registered.";
		}
		$stmt->close();
		header('Location: index.php');
	  }
  } else {
	$_SESSION['signup_error']= "Please enter a valid email address.";
	header('Location: index.php');
  }

?>
