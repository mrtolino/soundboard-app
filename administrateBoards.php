<?php
  require_once 'helperscripts/config.inc';

  session_start();
  if(!$_SESSION['allowed'] || !$_SESSION['admin']) {
    header('Location: index.php');
  }

  echo "<!DOCTYPE html>
  <html>
    <head>
      <meta charset='utf-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      <title>My Soundboards</title>
      <link rel='stylesheet' href='index.css'>
      <style>
        #heading {
          background-color: #f23a52;
        }
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
        <p>Administrator Mode</p>
        <span><p><a href='logout.php'>Logout</a></p></span>
        <span><p><a href='admin.php'>Admin Panel</a></p></span>
      </div>
      <div id='content'>";

  $userID = filter_var($_GET['userID'], FILTER_SANITIZE_STRING);

  $sql = "select title from Boards where u_user_id='$userID'";
  $result = mysqli_query($link, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $title = $row['title'];
      echo "<div class='sBoardDiv'>
              <p class='soundboardTitle'>$title</p>
              <button class='edit'>Edit</button>
              <button class='delete' style='display: none;'>Delete</button>
              <form class='getBoard' action='administrateBoard.php' method='get'>
                <input type='hidden' name='title' value='$title'>
                <input type='hidden' name='userID' value='$userID'>
              </form>
              <form class='deleteBoard' action='deleteboard.php' method='get'>
                <input type='hidden' name='title' value='$title'>
              </form>
            </div>";
    }
  }

  echo "<div id='createPublicBoard'>
          <p>Create Board</p>
          <form id='createBoard' action='addboard.php' method='post'>
            <input type='text' name='boardTitle' placeholder='Enter a title!' maxlength='30' required><br>
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
