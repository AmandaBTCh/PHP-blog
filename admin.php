<?php
/*
#########################################################################################
##                                                                                     ##
##    PHPeasynews - An easy to use functional news management script written in PHP    ##
##                                  Copyright 2003                                     ##
##                                                                                     ##
#########################################################################################

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

admin.php (version 2) file
*/

// Setting function of links... save repeating them

function menu(){
echo '<br /><br /><a href="post.php" class="penhyperlink">[Post News]</a> | <a href="newsarchive.php" class="penhyperlink">[Edit]</a> | <a href="usermanagement.php" class="penhyperlink">[Manage Users]</a> | <a href="versioncheck.php" class="penhyperlink">[Check if updates are available]</a> | <a href="admin.php?part=logout" class="penhyperlink">[Logout]</a><br /><br />';
}

// Part 2... If called, this section will set the cookies..
if(($_GET[part]) == ("2")){
setcookie("PEN_username", $_GET[username], time()+3600, "/");  /* expire in 1 hour */
setcookie("PEN_password", $_GET[pw], time()+3600, "/");  /* expire in 1 hour */

// Require header file
require("includes/header.php");

echo '<img src="logo.gif" alt="PHPeasynews"><br /><br />';

echo 'You are now logged in, thankyou ';
echo $_GET[username];

// Calling menu
menu();



// Calling Footer
require("includes/footer.php");
exit;
}
if(($_GET[part]) == ("logout")){
// Logout settings
// Deleting cookies...
setcookie("PEN_username", "", time()-3600, "/");
setcookie("PEN_password", "", time()-3600, "/");
echo '<img src="logo.gif" alt="PHPeasynews"><br /><br />';
echo 'Cookies deleted... You have now been <b>logged out</b><br /><br /><small><a href="admin.php" class="penhyperlink">[Log In]</a></small><br /><br />';
// Require header file
require("includes/header.php");
// Calling Footer
require("includes/footer.php");
exit;
}
// Require header file
require("includes/header.php");

// Right... STOP! Before we start working out if we should log this user in, first we must see if they are already logged in...
if(($access) == ("1")){
// Logged in...

echo '<img src="logo.gif" alt="PHPeasynews"><br /><br />';

// Lets tell the user that he/she is already logged in
echo "Welcome Back, $_COOKIE[PEN_username]!";

// Calling menu
menu();


// Calling Footer
require("includes/footer.php");
exit;
}

// Lets set the variable of $access... later on in the script, we will call this variable, if it is a 1, access is granted if it is a 0 access is denied.

$access = 0;

// Right lets see if the password has been submitted via the form


if (isset($_POST['submittedpassword'])){
$submittedpassword = $_POST['submittedpassword'];
}else{
$submittedpassword = "FALSE";
}

if (isset($_POST['submittedusername'])){
$submittedusername = $_POST['submittedusername'];
}else{
$submittedusername = "FALSE";
}

if (isset($_POST['beensubmitted'])){
$beensubmitted = $_POST['beensubmitted'];
}else{
$beensubmitted = "FALSE";
}

if(($beensubmitted) == ("TRUE")){

// Make the constant a variable for ease of use
$PEN_DB_TABLE3 = PEN_DB_TABLE3;

$submittedpasswordencrypted = md5($submittedpassword);

// Query
$query = "SELECT * FROM $PEN_DB_TABLE3 WHERE username = '$submittedusername'";

// If DEBUG is on then print the query above - Useful if somethings not working
if(($debug) == ("1")){
echo "<b>Query:</b> $query";
}

// Select Database
mysql_select_db(PEN_DB_NAME);

// Result
$result = mysql_query ($query);
if (mysql_num_rows($result) < 1) {
// No username in database...

// Invalid Username
$reasondenied = "username";
$access = 0;
}
while ($Row = mysql_fetch_array ($result)){
if(($Row[password]) == ($submittedpasswordencrypted)){
// Access Granted
$access = 1;
}else{
$access = 0;
// Wrong password
$reasondenied = "password";
}
}
// Access Accepted...
if(($access) == ("1")){

// Right... need to set cookies...
// However... output has already started... so we have to load a new page (Or load this page again)

echo "<meta content=\"0.5;url=$_SERVER[PHP_SELF]?part=2&username=$submittedusername&pw=$submittedpasswordencrypted\" http-equiv=\"REFRESH\">";
echo '<img src="logo.gif" alt="PHPeasynews"><br /><br />';
echo '<b>Please wait...</b> while you are being redirected...';
}else{
// Access Denied...
echo '<img src="logo.gif" alt="PHPeasynews"><br /><br />';
echo '<fieldset><legend>PHPeasynews - Please enter password</legend>';
echo '<form action="admin.php" method="post">';
echo '<table>';

// Why was the attempt denied?
if(($reasondenied) == ("username")){
// Username invalid (wasn't found in the database)
echo '<td><font color="red">Username not found</font></td></tr>';
}elseif(($reasondenied) == ("password")){
// Password invalid (didn't match the username's password in the db)
echo '<td><font color="red">Wrong Password</font></td></tr>';
}

echo '<tr><td class="form">Username:</td><td>';
echo '<input type="text" name="submittedusername" class="installtables"></td></tr>';
echo '<tr><td class="form">Password:</td><td>';
echo '<input type="password" name="submittedpassword" class="installtables"></td></tr>';
echo '<tr><td></td><td><input type="submit" value="Enter" class="installtables"></td></tr>';
echo '<input type="hidden" name="beensubmitted" value="TRUE">';
echo '</table>';
echo '</form>';
echo '</fieldset>';

}



// Close beensubmitted check
}else{
// Not been submitted... show password form...

echo '<img src="logo.gif" alt="PHPeasynews"><br /><br />';
echo '<fieldset><legend>PHPeasynews - Please enter password</legend>';
echo '<form action="admin.php" method="post">';
echo '<table>';
echo '<tr><td class="form">Username:</td><td>';
echo '<input type="text" name="submittedusername" class="installtables"></td></tr>';
echo '<tr><td class="form">Password:</td><td>';
echo '<input type="password" name="submittedpassword" class="installtables"></td></tr>';
echo '<tr><td></td><td><input type="submit" value="Enter" class="installtables"></td></tr>';
echo '<input type="hidden" name="beensubmitted" value="TRUE">';
echo '</table>';
echo '</form>';
echo '</fieldset>';

}
echo '<br />';
// Calling Footer
require("includes/footer.php");
?>