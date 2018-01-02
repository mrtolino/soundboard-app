<?php
session_start();
if(!$_SESSION['allowed']) {
  header('Location: index.php');
}

$title = $_GET['title'];
$page = $_GET['page'];
$pageNumber = $_GET['pageNumber'];

require_once 'helperscripts/config.inc';
print '<h1>hello</h1>';
/*
echo "
<p>
  <button id= 'changeView'>Change the view</button>
  <form id= 'changePage' action= 'listBoard.php' method='get'>
    <input type= 'hidden' name= 'title' value= \"$title\">
    <select id= 'choosePage' name= 'page'>
      <option value= 'all' "; if ($page == 'all') {echo "selected";} echo ">All</option>
      <option value= '5' ";   if ($page == '5') {echo "selected";}   echo ">5</option>
      <option value= '10' ";  if ($page == '10') {echo "selected";}  echo ">10</option>
      <option value= '20' ";  if ($page == '20') {echo "selected";}  echo ">20</option>
    </select>
    <input type= 'hidden' name= 'pageNumber' value= '1'>
  </form>
</p>";

// Count how many contents of the board there are for pagination
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

  echo "<form id= 'pageChange' action= 'listBoard.php' method = 'get'>
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

$result = mysqli_query($link, $sql);

if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $imgFileName = $row['u_img_filename'];
    $soundFileName = $row['u_sound_filename'];

    $imgFileNamePath = "./uploads/".$imgFileName;
    $soundFileNamePath = "./uploads/".$soundFileName;

    echo "<div class='soundDiv sBoardDiv' title=$soundFileName
               style='background-size: cover;
                      background-image: url(\"fetchimage.php?filename=$imgFileNamePath\");
                      display: block; margin: 20px auto'>
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
  $_SESSION['delete_board_error']:"";*/
?>
