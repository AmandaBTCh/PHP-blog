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

versioncheck.php file
*/
// Require Header File
require("includes/header.php");
// Close head open body
echo '</head><body>';

// Print a notice that DEBUG is on if its on - for security reasons
if(($debug) == ("1")){
echo '<b><font color="red">Warning: Debug Mode ON</font></b><br><br>';
}

// This page will check with the remote server to check if this version of PHPeasynews is the latest.
// The layout of the file this page will access:
/*
PHPeasynews        					// Name of the program
by ...             					// Developer's names
----------------   					// Seperator
Version Check:                  // Script will ignore this line
1											// Is version check enabled?
Version Activation Code:			// Script will ignore this line
N/A										// Activation code to re-enable the version check, should it be disabled remotely
Latest Version:						// Script will ignore this line
1.1 Alpha Developer's Edition	// The latest version of the script
*/



// Make the constant a variable for ease of use
$DB_TABLE2 = PEN_DB_TABLE2;

// Query
$query = "SELECT * FROM $DB_TABLE2 WHERE `option` = 'unlock_code' ORDER BY id";

// If DEBUG is on then print the query above - Useful if somethings not working
if(($debug) == ("1")){
echo "<b>Query:</b> $query";
}

// Select Database
mysql_select_db(PEN_DB_NAME);

// Result
$result = mysql_query ($query);

if(($_POST[beensubmitted]) == ("TRUE")){
while ($Row = mysql_fetch_array ($result)){
if(($Row[value]) == (md5($_POST[unlockcode]))){
// UNLOCK CODE ACCEPTED

// Unlock the version check feature.

// Make the constant a variable for ease of use
$DB_TABLE2 = PEN_DB_TABLE2;


$query = "UPDATE `$DB_TABLE2` SET `value` = 'N/A' WHERE `option` = 'unlock_code' LIMIT 1";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db(PEN_DB_NAME);

if(mysql_query ($query)){
echo '<b>Unlocked</b><br /><br />';
}

}else{
echo 'Code is wrong';

print("</div>");

// Calling Footer
require("includes/footer.php");

// End Page
exit;
}
}
}else{

while ($Row = mysql_fetch_array ($result)){
if(($Row[value]) != ("N/A")){
echo 'The PHPeasynews server has said before that the version check is disabled, this could be temporary or permant.<br /><br />To see if this is permant or temporary and for instructions on how to renable this feature visit: <a href="';
echo $pen_website_url;
echo '">';
echo $pen_website_url;
echo '</a><br /><br />If you have an unlock code to renable this script to check for the latest versions please enter it below:<br /><form method="POST" action="versioncheck.php"><input type="TEXT" name="unlockcode"><input type="hidden" name="beensubmitted" value="TRUE"><input type="submit" value="Unlock"></form>';

print("</div>");

// Calling Footer
require("includes/footer.php");

// End Page
exit;
}
}
}
// The current location of the script:
$location = "http://www.brettandbutter.co.uk/penversioncheck.txt";

$filearray = file($location, "r");

if(($debug) == ("1")){
echo "<b>File:</b><br /><br /><pre>";
print_r($filearray);
echo '</pre>';
}

$count = count($filearray);

if(($debug) == ("1")){
echo "<b>Count:</b> $count<Br />";
}

// Should contain 9 lines.. check integrity

if(($count) != ("9")){
if(($debug) == ("1")){
echo "Failed on Count<br />";
}
// There are not 9 lines in the file... So show an error
echo 'The PHPeasynews server seems to be providing a corrupt file. This could be a temporary error, or a bug.<br /><br /><b>Please try again later</b> if you get the same error, and you havn\'t modified versioncheck.php in anyway, then please register it as a bug at: <a href="';
echo $pen_website_url;
echo '">';
echo $pen_website_url;
echo '</a>';

print("</div>");

// Calling Footer
require("includes/footer.php");

// End Page
exit;
}

// Important lines are 1, 5, 7 & 9

$line = $filearray[0];
$line = trim($line);

if(($line) != ("PHPeasynews")){
if(($debug) == ("1")){
echo "'$line'";
echo "Name is wrong<br />";
}
// The first line doesn't say PHPeasynews... show an error
echo 'The PHPeasynews server seems to be providing a corrupt file. This could be a temporary error, or a bug.<br /><br /><b>Please try again later</b> if you get the same error, and you havn\'t modified versioncheck.php in anyway, then please register it as a bug at: <a href="';
echo $pen_website_url;
echo '">';
echo $pen_website_url;
echo '</a>';

print("</div>");

// Calling Footer
require("includes/footer.php");

// End Page
exit;
}

$line = $filearray[4];
$line = trim($line);

if(($line) == ("0")){
// Version check has been disabled remotely, this could be due to a bandwidth issue, so we must log not to ping the server again (unless a unlock key is offered on the website to re enable it)

echo 'The PHPeasynews server has said that the version check is now disabled, this could be temporary or permant.<br /><br />To see if this is permant or temporary and for instructions on how to renable this feature visit: <a href="';
echo $pen_website_url;
echo '">';
echo $pen_website_url;
echo '</a>';

$line = $filearray[6];
$line = trim($line);

// This will have the encrypted unlock code and will store it in the database eventually

// Make the constant a variable for ease of use
$DB_TABLE2 = PEN_DB_TABLE2;


$query = "UPDATE `$DB_TABLE2` SET `value` = '$line' WHERE `option` = 'unlock_code' LIMIT 1";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db(PEN_DB_NAME);

// Has it worked?

if(mysql_query ($query)){
if(($debug) == ("1")){
echo 'Unlock code in database';
}
}


exit;
}else{

// Make the constant a variable for ease of use
$DB_TABLE2 = PEN_DB_TABLE2;

$query = "UPDATE `$DB_TABLE2` SET `value` = 'N/A' WHERE `option` = 'unlock_code' LIMIT 1";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db(PEN_DB_NAME);

// Has it worked?

if(mysql_query ($query)){
if(($debug) == ("1")){
echo 'Unlock code in database';
}
}

}

$line = $filearray[8];
$line = trim($line);

// This will now explode the whole string so '1.1 Edition' will be '1.1' so we can use maths to work out if it a newer version

$versionnumber = explode(" ", $line);
$versionnumber = $versionnumber[0];

$localnumber = explode(" ", $pen_version_number);
$localnumber = $localnumber[0];

if(($localnumber) >= ($versionnumber)){
// Versions match

echo '<center>';
echo '<b>You have the latest version of PHPeasynews</b>';
echo '<br /><br />Version: <b>';
echo $line;
echo '</b><br /><br />Please check often for updates, new updates can fix bugs or/and add new features!<br /><br />';
echo '<a href="admin.php" class="penhyperlink">[Admin Menu]</a><br /><br />';
echo '</center>';

print("</div>");

// Calling Footer
require("includes/footer.php");

// End Page
exit;
}else{
echo 'There is a new version of PHPeasynews!<br /><br />You are running: <b>';
echo $pen_version_number;
echo '</b><br />The latest version is: <b>';
echo $line;
echo '</b><br /><br />You can download this version from the site: <a href="';
echo $pen_website_url;
echo '">';
echo $pen_website_url;
echo '</a>';
echo '<br /><br /><a href="admin.php" class="penhyperlink">[Admin Menu]</a><br /><br />';
print("</div>");

// Calling Footer
require("includes/footer.php");

// End Page

exit;
}

print("</div>");

// Calling Footer
require("includes/footer.php");

// End Page

?>