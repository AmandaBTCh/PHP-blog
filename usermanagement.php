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

echo '<b>PHPeasynews - User Management</b>';

// Need to check if this page has been called in any 'modes'...
// Modes: edit & delete...

if(($_GET[mode]) == ("edit")){

// Make the constant a variable for ease of use
$DB_TABLE3 = PEN_DB_TABLE3;

mysql_select_db(PEN_DB_NAME3);

// Query
$query = "SELECT * FROM $PEN_DB_TABLE3 WHERE id = '$_GET[user]' ORDER BY id";

// If DEBUG is on then print the query above - Useful if somethings not working
if(($debug) == ("1")){
echo "<b>Query:</b> $query";
}
// Result
$result = mysql_query ($query);
while ($Row = mysql_fetch_array ($result)){
$dbusername = $Row[username];
}

if(($_POST[beensubmitted]) != ("TRUE")){
echo '<fieldset><legend>PHPeasynews - Edit User</legend>';
echo '<form action="usermanagement.php?mode=edit" method="post">';
echo '<table>';
echo '<tr><td class="form">Username:</td><td>';
echo '<input type="text" name="submittedusername" class="installtables" value="';
echo $dbusername;
echo '"></td></tr>';
echo '<tr><td class="form">New Password (Leave blank if not changing):</td><td>';
echo '<input type="password" name="submittedpassword" class="installtables"></td></tr>';
echo '<tr><td></td><td><input type="submit" value="Edit" class="installtables"></td></tr>';
echo '<input type="hidden" name="beensubmitted" value="TRUE">';
echo "<input type=\"hidden\" name=\"user\" value=\"$_GET[user]\">";
echo '</table>';
echo '</form>';
echo '</fieldset>';
}else{
// Make the constant a variable for ease of use
$DB_TABLE3 = PEN_DB_TABLE3;

mysql_select_db(PEN_DB_NAME3);

$submittedpasswordc = trim($_POST[submittedpassword]);
if(($submittedpasswordc) == ("")){
$submittedpassword = "FALSE";
}
if(($submittedpassword) == ("FALSE")){
$query = "UPDATE $DB_TABLE3 SET username='$_POST[submittedusername]', permissions='a' WHERE id = '$_POST[user]' LIMIT 1";
}else{
$submittedencryptedpassword = md5($_POST[submittedpassword]);
$query = "UPDATE $DB_TABLE3 SET username='$_POST[submittedusername]', password='$submittedencryptedpassword', permissions='a' WHERE id = '$_POST[user]' LIMIT 1";

}
// If DEBUG is on then print the query above - Useful if somethings not working
if(($debug) == ("1")){
echo "<b>Query:</b> $query";
}
mysql_select_db(PEN_DB_NAME3);

if(mysql_query ($query)){
echo '<center><font color="green">You have successfully edited a user in the database.';
echo '</font><br><br></center>';
}else{
echo '<center><font color="red">Unfortunatly an error has occured. Please check your config.php settings. If still in doubt contact us.';
}




}

}elseif(($_GET[mode]) == ("delete")){

// Make the constant a variable for ease of use
$DB_TABLE3 = PEN_DB_TABLE3;

mysql_select_db(PEN_DB_NAME3);
if(($_POST[beensubmitted]) != ("TRUE")){
echo '<fieldset><legend>PHPeasynews - Are you sure?</legend>';
echo '<form action="usermanagement.php?mode=delete" method="post">';
echo '<table>';
echo '<tr><td class="form">Are you sure you want to delete this user?</td></tr>';
echo '<td><table><Tr><Td><input type="submit" value="Yes" class="installtables" name="submit"></td><td><input type="submit" name="submit" value="No" class="installtables"></td></tr></table></td>';
echo '<input type="hidden" name="beensubmitted" value="TRUE">';
echo "<input type=\"hidden\" name=\"user\" value=\"$_GET[user]\">";
echo '</table>';
echo '</form>';
echo '</fieldset>';

}else{

if(($_POST[submit]) == ("Yes")){
// Delete...

// Make the constant a variable for ease of use
$DB_TABLE3 = PEN_DB_TABLE3;

$query = "DELETE FROM `$DB_TABLE3` WHERE `id`='$_POST[user]' LIMIT 1";
mysql_select_db(PEN_DB_NAME3);

if(mysql_query ($query)){
echo '<center><font color="green">You have successfully deleted a user from the database.';
echo '</font></center>';
}else{
echo '<center><font color="red">Unfortunatly an error has occured. Please check your config.php settings. If still in doubt contact us.';
echo '</font><br></center>';
}

}else{
// Don't delete...
echo '<br /><br />User <b>not</b> deleted<br /><br />';
}

}

}

// This page will need to add new users to the database so more than one person can access the system, in the future everything will be permission based, only people with sufficent privlages will be allowed to add new users etc... however, I will build that later, or in a later release.

// Lets list all the users in the system....

// Make the constant a variable for ease of use
$DB_TABLE3 = PEN_DB_TABLE3;

mysql_select_db(PEN_DB_NAME);

// Query
$query = "SELECT * FROM $PEN_DB_TABLE3 ORDER BY id";

// If DEBUG is on then print the query above - Useful if somethings not working
if(($debug) == ("1")){
echo "<b>Query:</b> $query";
}

// Result
$result = mysql_query ($query);

echo '<br />';
echo '<b>Current Users:</b>';
echo '<br />';
while ($Row = mysql_fetch_array ($result)){
echo '<br />';
echo $Row[username];
if(($Row[id]) != ("1")){
echo ' :: <a href="usermanagement.php?mode=delete&user=';
echo $Row[id];
echo '" class="penhyperlink">[Delete User]</a>';

}else{
echo ' :: <a class="penhyperlinkdisabled"><i>[Delete User]</i></a>';
}
echo ' :: ';
// Editing...
echo '<a href="usermanagement.php?mode=edit&user=';
echo $Row[id];
echo '" class="penhyperlink">[Edit User]</a>';
}
echo '<br/><br/><a href="newuser.php" class="penhyperlink">[Add User]</a> | <a href="admin.php" class="penhyperlink">[Admin Menu]</a>';
// Calling Footer
require("includes/footer.php");
?>