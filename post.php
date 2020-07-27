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

admin.php file
*/
// Require header file
require("includes/header.php");

if(($access) == ("1")){

if (isset($_POST['beensubmitted'])){
$beensubmitted = $_POST['beensubmitted'];
}else{
$beensubmitted = "FALSE";
}

// If debug is not on and the page has been submitted then write the meta tag
/*
Disabled in RC2
if(($debug) != ("1")){
if(($beensubmitted) == ("TRUE")){
echo "<meta http-equiv=\"refresh\" content=\"3; url=$pen_siteurl\" />";
}
}
*/

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


// Make the constant a variable for ease of use
$DB_TABLE = PEN_DB_TABLE;

// If page has been submitted then run the INSERT	commands

if(($beensubmitted) == ("TRUE")){

$headline = $_POST['headline'];
$author = $_POST['author'];

$main = str_replace("\n", "<br />", $_POST['main']);

if(($_POST[emotions]) != ("1")){
        $emotions = 0;
        }else{
        $emotions = 1;
        }
        
$main = "[EMOTIONS=$emotions]$main";
$query = "INSERT INTO `$DB_TABLE` values ( '0', '$headline', '$main', NOW( ) , '$author', NOW( ) )";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db(PEN_DB_NAME);

// Has it worked?

if(mysql_query ($query)){
echo '<center><font color="green">You have successfully added a News Post to the database.';
echo '<br><br><A href="admin.php" class="penhyperlink">[Admin Menu]</a></font><br><br></center>';
}else{
echo '<center><font color="red">Unfortunatly an error has occured. Please check your config.php settings. If still in doubt contact us.';
echo '<br><br><A href="admin.php" class="penhyperlink">[Admin Menu]</a></font><br></center>';
}


}else{

echo '<fieldset><legend>PHPeasynews - Insert News</legend><form action="post.php" method="post">';
echo '<table><tr><td class="form">Headline (title):</td><td>';
echo '<input type="text" name="headline"></td></tr>';
echo '<tr><td class="form">Author:</td>';
echo '<td><input type="hidden" name="author" value="';
echo $loggedin_un;
echo '">';
echo "<i>$loggedin_un</i>";
echo '</td></tr>';
echo '<tr><td class="form">Main News:</td>';
echo '<td><textarea name="main" cols="40" rows="10"></textarea></td></tr>';
echo '<input type="hidden" name="beensubmitted" value="TRUE">';
echo '<tr><td></td><Td class="form">Emotions? (Default On, switch off if posting HTML code...) <input type="checkbox" name="emotions" value="1" checked></td></tr>';
echo '<tr><td><input type="submit" value="Insert"></td></tr>';
echo '</table>';
echo '</form>';
echo '</fieldset>';
}


}else{
echo '<font color="red">You are not logged in.</font>';
echo '<br /><br /><a href="admin.php" class="penhyperlink">[Log In]</a>';
}

// Page Ended

// Calling Footer
require("includes/footer.php");

?>
