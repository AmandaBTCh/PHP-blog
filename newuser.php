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

newuser.php file
*/

// Require Header File
require("includes/header.php");


// This page can only be accessed while logged on...

if(($access) == ("0")){
// Not logged in, direct to admin page...
echo "<meta http-equiv=\"refresh\" content=\"0.1; url=admin.php\" />";
exit;
}

if(($debug) != ("1")){
if(($_POST[beensubmitted]) == ("TRUE")){
echo "<meta http-equiv=\"refresh\" content=\"3; url=$pen_siteurl\" />";
}
}

// Close head open body
echo '</head><body>';

// Print a notice if debug is on - so the user knows its on and knows its a security risk
if(($debug) == ("1")){
echo '<b><font color="red">Warning: Debug Mode ON - Will <i>not</i> redirect</font></b><br><br>';
echo 'Site Name: ';
echo $pen_sitename;
echo '<br>Site URL: ';
echo $pen_siteurl;
}

// This page will need to add new users to the database so more than one person can access the system, in the future everything will be permission based, only people with sufficent privlages will be allowed to add new users etc... however, I will build that later, or in a later release.

if(($_POST[beensubmitted]) != ("TRUE")){

echo '<fieldset><legend>PHPeasynews - Add User</legend>';
echo '<form action="newuser.php" method="post">';
echo '<table>';
echo '<tr><td class="form">New Users Username:</td><td>';
echo '<input type="text" name="submittedusername" class="installtables"></td></tr>';
echo '<tr><td class="form">New Users Password:</td><td>';
echo '<input type="password" name="submittedpassword" class="installtables"></td></tr>';
echo '<tr><td></td><td><input type="submit" value="Add" class="installtables"></td></tr>';
echo '<input type="hidden" name="beensubmitted" value="TRUE">';
echo '</table>';
echo '</form>';
echo '</fieldset>';

}else{

// Make the constant a variable for ease of use
$DB_TABLE3 = PEN_DB_TABLE3;

// We need to encrypt passwords...
$submittedencryptedpassword = md5($_POST[submittedpassword]);

$query = "INSERT INTO `$DB_TABLE3` values ( '0', '$_POST[submittedusername]', '$submittedencryptedpassword', 'a')";
mysql_select_db(PEN_DB_NAME3);

if(mysql_query ($query)){
echo '<center><font color="green">You have successfully added a new user to the database.';
echo '<br><br>This page will redirect to your home page in 3 seconds.</font><br><br></center>';
}else{
echo '<center><font color="red">Unfortunatly an error has occured. Please check your config.php settings. If still in doubt contact us.';
echo '<br><br>This page will redirect to your home page in 3 seconds.</font><br></center>';
}
}

// Calling Footer
require("includes/footer.php");
?>