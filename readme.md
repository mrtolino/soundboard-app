Shanasahugh CSE135 Team project 3

Homepage URL: 162.243.155.129 (Please note that the homepage nav buttons are currently not functional -- we just added them for later use!) TA SSH address: ta@162.243.155.129

Website login: username -- shanasahugh password -- ShaNasaHugh0987^%

"ta" user account su (root) escalation (this is the password that's asked for when running the "su" command on "ta" account) password -- ShaNasaHugh0987^%

Instructions:

Where is it:

The homepage of our project 3 is at http://162.243.155.129/homework3/index.php and this is also
where all the public soundboards appear. The user can click on any public soundboard to
see the sounds w/ their pictures. We use our own CSS instead of Bootstrap.
l
Create, Read, Update and Delete:

In order to make changes, the user must log in to his/her account using the buttons on
the top right corner. After signed in, the user will be redirected to his/her homepage,
"myboard.php", where he can view and modify all the soundboards he/she has created.
In order to create a new board, pls use the last board with the name "Create Board". The user can do the same thing to all the sounds that he/she has uploaded to his/her soundboards. The UI is pretty intuitive and the user should easily view, update and upload sounds.

In order to see all the public boards, please click on the home button on the top right corner.
Note that the user cannot make changes to those public boards. The user can only make changes
to the boards he/she created in the user's homepage "myboard.php".

Administrator panel:

We specifically make it that nobody can create an account with administrator privilege and
the only way to make an administrator account is to do SQL queries directly. We have made
an admin account for you to check. Login as username: shant and password: shant, then type
the following url: http://162.243.155.129/homework3/admin to go to the admin panel.

In this panel, administrator can view and delete every non-admin user created on the database.

Admin users can also click on the user pad and see their soundboards, and make changes just like
the user himself/herself.

Logging

We have 3 tables to store logs.
Connect to the server using ssh, then run "mysql -u root -p", password is ShaNasaHugh0987^%.
Then run "USE Soundboard;" to select our database.
After your are in, run "SELECT * FROM log_baccess;" to view the logs for board access.
In the log_username section, visitor stands for a public user.
Run "SELECT * FROM log_saccess;" to view the logs for sound files.
In the log_username section, visitor stands for a public user as well.
Run "SELECT * FROM log_login;" to view the logs for sound files.
In the log_inout section, 1 stands for login, 0 stands for logout.
In the log_issuccessful section, 1 stands for success, 0 stands for failure.

User input validation
We have added string sanitization and prepared statement whenever we take input from users.
These situations include login, signup, and updating names of Soundboard.
These files include dosignup.php, dologin.php, and editBoard.php.


CHANGES FROM HOMEWORK3:

Check the performance.txt file in the repo; the PDF version is included in the email
that we have sent to the TAs.
