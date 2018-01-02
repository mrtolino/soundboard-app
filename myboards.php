<?php
  require_once 'helperscripts/config.inc';

  session_start();
  if(!$_SESSION['allowed']) {
    header('Location: index.php');
  }
  /*if (!isset($_GET['page']) || !isset($_GET['pageNumber'])) {
    header('Location:myboards.php?page=all&pageNumber=1');
  }

  $page = $_GET['page'];
  $pageNumber = $_GET['pageNumber'];

  if($page != '8' && $page != '12' && $page != '20' && $page != 'all') {
    header('Location:myboards.php?page=all&pageNumber=1');
  } else if ($pageNumber > 100 || $pageNumber < 0) {
    header('Location:myboards.php?page=all&pageNumber=1');
  } else if ($pageNumber == '') {
    header('Location:myboards.php?page=all&pageNumber=1');
  }
  */

  echo "<!DOCTYPE html>
  <html>
    <head>
      <meta charset='utf-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      <title>My Soundboards</title>
      <link rel='stylesheet' href='index.css'>
      <style>
        #content > div {
          position: relative;
          height: 300px;
        }
        p {
          margin: 5px;
        }
        .edit {
          position: absolute;
          bottom: 10px;
          right: 10px;
        }
        .delete {
          position: absolute;
          bottom: 10px;
          left: 10px;
        }
        .soundboardTitle {
          font-size: 26px;
        }
      </style>
    </head>
    <body>
      <div id='heading'>
        <p>My Soundboards</p>
        <span><p><a href='logout.php'>Logout</a></p></span>
        <span><p><a href='index.php'>Home</a></p></span>
      </div>
      <div id='content'>";

      /*<p>
        <button id= 'changeView'>Change the view</button>
        <form id= 'changePage' action= 'myboards.php' method='get'>
          <select id= 'choosePage' name= 'page'>
            <option value= 'all' "; if ($page == 'all') {echo "selected";} echo ">All</option>
            <option value= '8' ";   if ($page == '8') {echo "selected";}   echo ">8</option>
            <option value= '12' ";  if ($page == '12') {echo "selected";}  echo ">12</option>
            <option value= '20' ";  if ($page == '20') {echo "selected";}  echo ">20</option>
          </select>
          <input type= 'hidden' name= 'pageNumber' value= '1'>
        </form>
      </p>*/

  $user = $_SESSION['user'];
  $sql = "select u_id from Users where u_uname='$user'";
  $result = mysqli_query($link, $sql);

  $row = mysqli_fetch_assoc($result);
  $uid = $row['u_id'];

/*
  $sql = "select COUNT(title) as total from Boards where u_user_id='$uid'";
  $result = mysqli_query($link, $sql);
  if($result) {
    $row = mysqli_fetch_assoc($result);
    $total = $row['total'];
  }

  if($page == 'all') {
    $sql = "select title from Boards where u_user_id='$uid'";
  }
  else if($total > $page) {
    $lowerBound = $page * ($pageNumber - 1);
    $pages = min ($page, $total);
    $sql="select title from Boards where u_user_id='$uid' limit $lowerBound, $pages";
    echo "<form id= 'pageChange' action= 'myboards.php' method = 'get'>
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
    $sql = "select title from Boards where u_user_id='$uid'";
  }
  */

  $sql = "select title from Boards where u_user_id='$uid'";
  $result = mysqli_query($link, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $title = $row['title'];
      echo "<div class='sBoardDiv'>
              <p class='soundboardTitle'>$title</p>
              <button class='edit'>Edit</button>
              <button class='delete' style='display: none;'>Delete</button>
              <form class='getBoard' action='board.php' method='get'>
                <input type='hidden' name='title' value='$title' pattern='[a-zA-Z0-9]+'>
                <!--<input type = 'hidden' name= 'page' value = 'all'>
                <input id = 'pageNumber' type= 'hidden' name= 'pageNumber' value= '1'>-->
              </form>
              <form class='deleteBoard' action='deleteboard.php' method='get'>
                <input type='hidden' name='title' value='$title' pattern='[a-zA-Z0-9]+'>
              </form>
            </div>";
    }
  }

  echo "<div id='createPublicBoard'>
          <p>Create Board</p>
          <form id='createBoard' action='addboard.php' method='post'>
            <input type='text' name='boardTitle' placeholder='Enter a title!' maxlength='30' required pattern='[a-zA-Z0-9]+'><br>
            <label for='public'>Public: </label><br>
            <label for='public'>Yes </label>
            <input name='public' type='radio' value='1' checked>
            <label for='public'>No </label>
            <input name='public' type='radio' value='0'><br>
            <input type='submit' value='Create'>
          </form>
        </div>
      </div>
      <footer>&copy; Shanasahugh 2017</footer>
      <script type='text/javascript'>
        window.onload = function() {
          var boards = document.querySelectorAll('#content > div');
          var deleteBtns = document.querySelectorAll('#content .delete');
          var editBtns = document.querySelectorAll('#content .edit');
          var editTitles = document.querySelectorAll('#content p');
          var getBoardForms = document.querySelectorAll('#content .getBoard');
          var deleteBoardForms = document.querySelectorAll('#content .deleteBoard');
          /*var changeView = document.querySelector('#changeView');
          var changePage = document.querySelector('#changePage');
          var choosePage = document.querySelector('#choosePage');
          var pageChange = document.querySelector('#pageChange');
          var pageNumber = document.querySelector('#pageNumber');
          var prevBtn = document.querySelector('#prev');
          var nextBtn = document.querySelector('#next');*/

          /*
          changeView.addEventListener('click', function() {
            window.location = 'listMyBoards.php?page=all&pageNumber=1';
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

          for (var index = 0; index < boards.length-1; index++) {
            (function (board, form, deleteBtn) {
              board.addEventListener('click', function() {
                if (deleteBtn.style.display == 'none') {
                  form.submit();
                }
              });
            })(boards[index], getBoardForms[index], deleteBtns[index]);

            (function (deleteBtn, deleteBoardForm) {
              deleteBtn.addEventListener('click', function () {
                deleteBoardForm.submit();
              });
            })(deleteBtns[index], deleteBoardForms[index]);

            (function (editBtn, editTitle, deleteBtn) {
              var currTitle = document.querySelector('#content > div > .soundboardTitle').innerHTML;

              editBtn.addEventListener('click', function (e) {
                var editTitleForm = document.querySelector('#editTitleForm');

                e.stopPropagation();
                if (deleteBtn.style.display == 'none') {
                  deleteBtn.style.display = '';
                } else {
                  deleteBtn.style.display = 'none';
                }

                if (editTitleForm) {
                  editTitleForm.remove();
                  editTitle.innerHTML = currTitle;
                } else {
                  var prevTitle = editTitle.innerHTML;

                  var form = document.createElement('form');
                  form.setAttribute('id', 'editTitleForm');
                  form.setAttribute('action', 'editBoard.php');
                  form.setAttribute('method', 'get');

                  var newTitle = document.createElement('input');
                  newTitle.setAttribute('type', 'text');
                  newTitle.setAttribute('value', prevTitle);
                  newTitle.setAttribute('name', 'newTitle');
                  newTitle.setAttribute('maxlength', '30');

                  var oldTitle = document.createElement('input');
                  oldTitle.setAttribute('type', 'hidden');
                  oldTitle.setAttribute('name', 'oldTitle');
                  oldTitle.setAttribute('value', prevTitle);

                  var changePublic = document.createElement('input');
                  var changePublicLabel = document.createElement('label');
                  changePublicLabel.innerHTML = 'Public? ';
                  changePublic.setAttribute('type', 'checkbox');
                  changePublic.setAttribute('name', 'public');
                  changePublic.setAttribute('value', '1');

                  var submit = document.createElement('input');
                  submit.setAttribute('type', 'submit');
                  submit.setAttribute('value', 'Done');

                  form.appendChild(newTitle);
                  form.appendChild(oldTitle);
                  form.appendChild(submit);
                  form.appendChild(document.createElement('br'));
                  form.appendChild(changePublicLabel);
                  form.appendChild(changePublic);
                  editTitle.innerHTML = '';
                  editTitle.appendChild(form);
                }
              });
            }) (editBtns[index], editTitles[index], deleteBtns[index]);
          } // end of for loop
        };
      </script>
    </body>
  </html>";
?>
