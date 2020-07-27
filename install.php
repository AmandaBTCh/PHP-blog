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

install.php file
*/
// Call the header file.
require("includes/header.php");
// Close head open body
echo '</head><body>';

// Debugging Section
// If debug is on print a notice so that the user knows its on

if(($debug) == ("1")){
echo '<b><font color="red">Warning: Debug Mode ON</font></b><br><br>';
}

if(($_POST[reset]) == ("Reset Database")){
$reset = "1";
}else{
$reset = $_POST[reset];
}
if(($reset) == ("1")){

echo 'Are you sure you want to reset the database? If you have a working installation of PHPeasynews, you do not need to run this script! If you do, <b>you will lose all your data for PHPeasynews</b>.';
echo '<br /><br /><b>This will not affect any other tables/databases apart from the PHPeasynews ones</b>';
echo '<br /><br />';
echo "<br /><form action=\"install.php\" method=\"post\"><input type=\"hidden\" name=\"database\" value=\"$_POST[database]\"><input type=\"hidden\" name=\"table1\" value=\"$_POST[table1]\"><input type=\"hidden\" name=\"table2\" value=\"$_POST[table2]\"><input type=\"hidden\" name=\"table3\" value=\"$_POST[table3]\"><input type=\"hidden\" name=\"host\" value=\"$_POST[host]\"><input type=\"hidden\" name=\"username\" value=\"$_POST[username]\"><input type=\"hidden\" name=\"password\" value=\"$_POST[password]\">
<input type=\"hidden\" name=\"reset\" value=\"2\">
<input type=\"hidden\" name=\"type\" value=\"1\">
<input type=\"submit\" value=\"Reset Database with details on the form (For failed installations)\"></form>";
echo "<br /><form action=\"install.php\" method=\"post\">
<input type=\"hidden\" name=\"reset\" value=\"2\">
<input type=\"hidden\" name=\"type\" value=\"2\">
<input type=\"submit\" value=\"Reset Database with details in config.php file (For people wishing to reset PHPeasynews but had a working version before)\"></form>";

echo '<br/><br/>';
// Calling Footer
require("includes/footer.php");
exit;
}

if(($_POST[reset]) == ("2")){

if(($_POST[type]) == ("1")){
$dbc = @mysql_connect ($_POST[host], $_POST[username], $_POST[password]) or die ('<center><b>PHPeasynews</b><br><br><font color="red"><b>Error:</b> Could not connect to mySQL database - Please e-mail the webmaster at <a href="mailto:' . $toemail . '">' . $toemail . '</a> with any details you get on this page<br><br>If the error below says "Access denied for user" then this <i>could</i> be caused by incorrect details, please check again.<br><br><b>Details:</b> ' . mysql_error() . '</font></center><br><br><center><small><b>PHPeasynews</b><br>Version: ' . $pen_version_number . '<br><a href="' . $pen_website_url . '" target="_blank">' . $pen_website_url . '</a></small></center>');

$table1 = $_POST[table1];
$database = $_POST[database];
$table2 = $_POST[table2];
$table3 = $_POST[table3];
}elseif(($_POST[type]) == ("2")){
require("includes/config.php");

// Make the constant a variable for ease of use
$table1 = PEN_DB_TABLE;

// Make the constant a variable for ease of use
$table2 = PEN_DB_TABLE2;

// Make the constant a variable for ease of use
$table3 = PEN_DB_TABLE3;

$database = PEN_DB_NAME;
mysql_select_db(PEN_DB_NAME);
}
$query = "DROP TABLE `$table1`";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db($database);

// Has it worked?

echo '<br />';
echo 'Deleting table 1... ';
if(mysql_query ($query)){
echo '<font color="green">Success!';
echo '</font>';
}else{
echo '<font color="red">Failed!';
echo '<br />Are the details entered correctly? Does this table exist to be reset?</font>';
}

$query = "DROP TABLE `$table2`";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db($database);

// Has it worked?

echo '<br />';
echo 'Deleting table 2... ';
if(mysql_query ($query)){
echo '<font color="green">Success!';
echo '</font>';
}else{
echo '<font color="red">Failed!';
echo '<br />Are the details entered correctly? Does this table exist to be reset?</font>';
}

$query = "DROP TABLE `$table3`";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db($database);

// Has it worked?

echo '<br />';
echo 'Deleting table 3... ';
if(mysql_query ($query)){
echo '<font color="green">Success!';
echo '</font>';
}else{
echo '<font color="red">Failed!';
echo '<br />Are the details entered correctly? Does this table exist to be reset?</font>';
}

echo '<br/><br/>';
echo 'Please note: It is normal for only a few of the processes above to show "Success" so even though all three may not show "Success" the chances are the database has been reset. Please try to install again, A common cause for installation failure is that the config.php file is not chmodded to 766, causing the last stage to fail, please make sure it is chmodded 766 before you continue...';
echo '<br /><a href="install.php">Click here to install again</a>';
echo '<br/><br/>';
// Calling Footer
require("includes/footer.php");
exit;
}

if(($_POST[beensubmitted]) != ("TRUE")){
?>
<form action="install.php" method="POST">
<table width="100%" border="0" class="installtablemain">
<tr><td>
<b>PHPeasynews - Install script</b>
<br />
<p>Welcome to PHPeasynews! Thank you for choosing this script for your news management! PHPeasynews is a free script, written by Brett Jenkins.</p>
<p>This page has a series of simple to answer questions, which will setup PHPeasynews for you automaticly!
<br />Hope you enjoy PHPeasynews,
<br /><b>Brett Jenkins</b>
<br /><br /><br /><br />
<b>Database Settings</b>
<br />
<br />
</tr></td>
<tr><td>
<table width="100%" border="0" class="installtablemain">
<tr><td>Host:</td><td><input type="text" name="host" value="localhost" class="installtables"></td></tr>
<tr><td>Database:</td><td><input type="text" name="database" value="pen" class="installtables"></td></tr>
<tr><td>Database Username:</td><td><input type="text" name="username" value="username" class="installtables"></td></tr>
<tr><td>Database Password:</td><td><input type="password" name="password" value="" class="installtables"></td></tr>
<tr><td>Table 1:</td><td><input type="text" name="table1" value="pen_news" class="installtables"></td></tr>
<tr><td>Table 2:</td><td><input type="text" name="table2" value="pen_extra" class="installtables"></td></tr>
<tr><td>Table 3:</td><td><input type="text" name="table3" value="pen_users" class="installtables"></td></tr>
<tr><td>PHPeasynews Username (More can be added later):</td><td><input type="text" name="penuser" value="admin" class="installtables"></td></tr>
<tr><td>PHPeasynews Password:</td><td><input type="password" name="penpass" value="" class="installtables"></td></tr>
</table>
</td></tr>
<tr><td>
<br />
<b>PHPeasynews Settings</b>
<br />
<br />
</td></tr>
<tr><td>
<table width="100%" class="installtablemain">
<tr><td>E-mail
The e-mail to display to users with errors to contact.
This is to ensure that all the config.php options are configured properly
If you cannot find the problem then please go to our URL at
https://sourceforge.net/projects/phpeasynews
and contact us.</td></tr>
<tr><td><input type="text" name="email" value="joe@bloggs.com" class="installtables"></td></tr>
<tr><td>Path to main directory of PHPeasynews
<br />ie: folder/folder/finalfolder
<br />(Basically what you get after the domain, so if your files were at www.domain.com/pen then you would put in just: pen)
<br /><b>No Trailing Slash otherwise you will get errors!</b></td></tr>
<tr><td><input type="text" name="path" value="path/to/pen" class="installtables"></td></tr>
<tr><td>Name of your site
<br />ie: Blue Whale</td></tr>
<tr><td><input type="text" name="sitename" value="PHPeasynews" class="installtables"></td></tr>

<tr><td>URL of your site
<br />The domain (<b>not the location of the PEN directory</b>) - so www.domain.com <b>not</b> www.domain.com/pen
<br />ie: http://www.brettjenkins.co.uk</td></tr>

<tr><td><input type="text" name="url" value="http://www.brettjenkins.co.uk" class="installtables"></td></tr>
</table>
</td></tr>
<tr><td>
<br />
<b>Cosmetic Settings</b>
<br /><br />
</td></tr>
<tr><td>
<table width="100%" class="installtablemain">
<tr><td>CSS
Background of news header
<br />Default: #E7E7E7</td></tr>
<tr><td><input type="text" name="css_tableheader" value="#E7E7E7" class="installtables"></td></tr>

<tr><td>Background of news main content
<br />Default: #FFFFFF</td></tr>
<tr><td><input type="text" name="css_tablemain" value="#FFFFFF" class="installtables"></td></tr>

<tr><td>Background of the Individual Headlines on the Newsarchive page
<br />Default: #FFFFFF</td></tr>
<tr><td><input type="text" name="css_newsarchive" value="#FFFFFF" class="installtables"></td></tr>

<tr><td>Color on the "Written By, On, at" text on newsarchive
<br />Default: #878787</td></tr>
<tr><td><input type="text" name="css_na_writtenbyonat" value="#878787" class="installtables"></td></tr>


<tr><td>Color on the Author Date and Time on newsarchive
<br />Default: #4D4D4D</td></tr>
<tr><td><input type="text" name="na_authordatetime" value="#4d4d4d" class="installtables"></td></tr>

<tr><td>Default hyperlink colour for the script
<br />Default: #000080</td></tr>
<tr><td><input type="text" name="css_na_hyperlink" value="#000080" class="installtables"></td></tr>

<tr><td>Default hyperlink colour for the script - Hover
<br />Default: #4040FF</td></tr>

<tr><td><input type="text" name="css_na_hyperlink_hover" value="#4040FF" class="installtables"></td></tr>

<tr><td>How many news postings to display on the news page
<br />Default: 10</td></tr>
<tr><td><input type="text" name="pen_newsnum" value="10" class="installtables"></td></tr>
</table>
<tr><td>
<input type="hidden" name="beensubmitted" value="TRUE">
<input type="submit" value="Install">
<input type="submit" value="Reset Database" name="reset"></form>

</td></tr></table>
<?php
}elseif(($_POST[beensubmitted]) == ("TRUE")){
$error = 0;

$filename = 'includes/config.php';
$somecontent = "<?php
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

config.php file
*/
// This file is the file to edit your settings in.
// Unless you know what you are doing please dont edit any other files.

// Database Username
// Change this to the mySQL username your ISP has given you

define ('PEN_DB_USER', '$_POST[username]');

// Database Password
// Change this to the mySQL password your ISP has given you

define ('PEN_DB_PASSWORD', '$_POST[password]');

// Database Host
// For most ISP's / Servers localhost will work fine, however if you experience problems please
// contact your ISP

define ('PEN_DB_HOST', '$_POST[host]');

// Database Name
// The database you will be using. PHPeasynews CAN be used in a database with other unrelated tables.

define ('PEN_DB_NAME', '$_POST[database]');

// Table Name
// The table - currently there is only one used - in your mySQL database that PHPeasynews will use.
// Please see the manual for more infomation.

define ('PEN_DB_TABLE', '$_POST[table1]');

// Table Name
// The table to hold extra options for the script's more advanced features.
// Please see the manual for more infomation.

define ('PEN_DB_TABLE2', '$_POST[table2]');

// Table Name
// The table to hold usernames and passwords.
// Please see the manual for more infomation.

define ('PEN_DB_TABLE3', '$_POST[table3]');

// E-mail
// The e-mail to display to users with errors to contact.
// This is to ensure that all the config.php options are configured properly
// If you cannot find the problem then please go to our URL at
// https://sourceforge.net/projects/phpeasynews
// and contact us.

\$toemail = \"$_POST[email]\";

// Path to main directory of PHPeasynews
// ie: folder/folder/finalfolder (Basically what you get after the domain, so if your files were at www.domain.com/pen then you would put in just: pen)
// No Trailing Slash otherwise you will get errors!

\$pen_includepath = \"$_POST[path]\";

// Name of your site
// ie: Blue Whale

\$pen_sitename = \"$_POST[sitename]\";

// URL of your site - The domain (not the location of the PEN directory)
// ie: http://www.blue-whale.net

\$pen_siteurl = \"$_POST[url]\";

//
// Cosmetic Settings
//

// CSS
// Background of news header
// Default: #E7E7E7
\$css_tableheader = \"$_POST[css_tableheader]\";

// Background of news main content
// Default: white
\$css_tablemain = \"$_POST[css_tablemain]\";

// Background of the Individual Headlines on the Newsarchive page
// Default: white
\$css_newsarchive = \"$_POST[css_newsarchive]\";

// Color on the \"Written By, On, at\" text on newsarchive
// Default: #878787
\$css_na_writtenbyonat = \"$_POST[css_na_writtenbyonat]\";

// Color on the Author Date and Time on newsarchive
// default: #4D4D4D
\$na_authordatetime = \"$_POST[na_authordatetime]\";

// How many news postings to display on the news page
// ie: 10
\$pen_newsnum = \"$_POST[pen_newsnum]\";

// Default hyperlink colour for the script
// Default: #000080
\$css_hyperlink = \"$_POST[css_na_hyperlink]\";

// Default hyperlink colour for the script - Hover
// Default: #4040FF
\$css_hyperlink_hover = \"$_POST[css_na_hyperlink_hover]\";

// Do not edit below this line unless you know what you are doing




// Connect String

\$dbc = @mysql_connect (PEN_DB_HOST, PEN_DB_USER, PEN_DB_PASSWORD) or die ('<center><b>PHPeasynews</b><br><br><font color=\"red\"><b>Error:</b> Could not connect to mySQL database - Please e-mail the webmaster at <a href=\"mailto:' . \$toemail . '\">' . \$toemail . '</a> with any details you get on this page<br><br>If the error below says \"Access denied for user\" then this <i>could</i> be caused by incorrect infomation in the config.php file<br><br><b>Details:</b> ' . mysql_error() . '</font></center><br><br><center><small><b>PHPeasynews</b><br>Version: ' . \$pen_version_number . '<br><a href=\"' . \$pen_website_url . '\" target=\"_blank\">' . \$pen_website_url . '</a></small></center>');


// End File

?>


";

echo 'Is Config.php writable? ';
if(!is_writable($filename)){
// Not writable

echo '<font color="red">No!';
echo '</font>';
echo '<br />';
echo '<font color="red">Failed!';
echo '<br /><br />Installation can not continue, please chmod /includes/config.php to 766 before running this installation again';
echo '</font>';
echo '<br /><br />';
// Page Ended

// Calling Footer
require("includes/footer.php");

exit;

}else{
// Writable!
echo '<font color="green">Yes!';
echo '</font>';
}
echo '<br />';
$dbc = @mysql_connect ($_POST[host], $_POST[username], $_POST[password]) or die ('<center><b>PHPeasynews</b><br><br><font color="red"><b>Error:</b> Could not connect to mySQL database - Please e-mail the webmaster at <a href="mailto:' . $toemail . '">' . $toemail . '</a> with any details you get on this page<br><br>If the error below says "Access denied for user" then this <i>could</i> be caused by incorrect details, please check again.<br><br><b>Details:</b> ' . mysql_error() . '</font></center><br><br><center><small><b>PHPeasynews</b><br>Version: ' . $pen_version_number . '<br><a href="' . $pen_website_url . '" target="_blank">' . $pen_website_url . '</a></small></center>');

$query = "CREATE TABLE `$_POST[table1]` (`id` int(10) unsigned NOT NULL auto_increment, `headline` text NOT NULL, `main` text NOT NULL, `date` date NOT NULL default '0000-00-00', `author` text NOT NULL, `time` time NOT NULL default '00:00:00', PRIMARY KEY  (`id`)) TYPE=MyISAM AUTO_INCREMENT=15 ; ";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db($_POST[database]);

// Has it worked?

echo 'Creating table 1... ';
if(mysql_query ($query)){
echo '<font color="green">Success!';
echo '</font>';

$query = "INSERT INTO `$_POST[table1]` VALUES (0, 'Welcome to PHPeasynews!', 'If you can see this then your installation and configuration of PHPeasynews seems to have been successful!<br><br>Congratulations<br><br>Thanks for installing our software<br><b>PHPeasynews Development team</b>', NOW(), 'PHPeasynews', NOW()); ";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db($_POST[database]);

// Has it worked?

echo '<br />Inserting data into table 1... ';
if(mysql_query ($query)){
echo '<font color="green">Success!';
echo '</font>';

}

$query = "CREATE TABLE `$_POST[table2]` (`id` int(10) unsigned NOT NULL auto_increment, `option` text NOT NULL, `value` text NOT NULL, PRIMARY KEY  (`id`)) TYPE=MyISAM AUTO_INCREMENT=2 ; ";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db($_POST[database]);

// Has it worked?

echo '<br />Creating table 2... ';
if(mysql_query ($query)){
echo '<font color="green">Success!';
echo '</font>';

$query = "INSERT INTO `$_POST[table2]` VALUES (1, 'unlock_code', 'N/A');";

// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db($_POST[database]);

// Has it worked?

echo '<br />Inserting data into table 2... ';
if(mysql_query ($query)){
echo '<font color="green">Success!';
echo '</font>';


$query = "CREATE TABLE `$_POST[table3]` (`id` int(10) unsigned NOT NULL auto_increment, `username` text NOT NULL, `password` text NOT NULL, `permissions` text NOT NULL, PRIMARY KEY  (`id`) ) TYPE=MyISAM AUTO_INCREMENT=1 ;";


// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db($_POST[database]);

// Has it worked?

echo '<br />Creating table 3... ';
if(mysql_query ($query)){
echo '<font color="green">Success!';
echo '</font>';
$penpass = md5($_POST[penpass]);
$query = "INSERT INTO `$_POST[table3]` VALUES (1, '$_POST[penuser]', '$penpass', 'a');";

/* User permissions guide:
a: Admin (Can do everything)

More to come...
*/
// DEBUG

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

// END DEBUG

// Select Database

mysql_select_db($_POST[database]);

// Has it worked?

echo '<br />Inserting data into table 3... ';
if(mysql_query ($query)){
echo '<font color="green">Success!';
echo '</font>';


echo '<br />Writing config file... ';
// Let's make sure the file exists and is writable first.
if (is_writable($filename)) {

   // In our example we're opening $filename in append mode.
   // The file pointer is at the bottom of the file hence
   // that's where $somecontent will go when we fwrite() it.
   if (!$handle = fopen($filename, 'w')) {
echo '<font color="red">Failed!</font>';
$error = 1;
   }

   // Write $somecontent to our opened file.
   if (fwrite($handle, $somecontent) === FALSE) {
echo '<font color="red">Failed!</font>';
$error = 1;
   }

   echo '<font color="green">Success!';
echo '</font>';

   fclose($handle);

} else {
   echo '<font color="red">Failed!</font>';
$error = 1;
}
// End file name
}else{
echo '<font color="red">Failed!</font>';
$error = 1;
}
}else{
echo '<font color="red">Failed!</font>';
$error = 1;
}
}else{
echo '<font color="red">Failed!</font>';
$error = 1;
}

}else{
echo '<font color="red">Failed!</font>';
$error = 1;

}
}else{
echo '<font color="red">Failed!</font>';
$error = 1;

}
}else{
echo '<font color="red">Failed!</font>';
$error = 1;

}

if(($error) == ("1")){
echo '<br /><br /><center><font color="red">Unfortunatly an error has occured. This could be due to wrong settings, or the install script has already been run successfully. If still in doubt please contact us.';
echo '<br /><br />You may need to reset the database before this install script will work';
echo "<br /><form action=\"install.php\" method=\"post\"><input type=\"hidden\" name=\"database\" value=\"$_POST[database]\"><input type=\"hidden\" name=\"table1\" value=\"$_POST[table1]\"><input type=\"hidden\" name=\"table2\" value=\"$_POST[table2]\"><input type=\"hidden\" name=\"table3\" value=\"$_POST[table3]\"><input type=\"hidden\" name=\"host\" value=\"$_POST[host]\"><input type=\"hidden\" name=\"username\" value=\"$_POST[username]\"><input type=\"hidden\" name=\"password\" value=\"$_POST[password]\"><input type=\"hidden\" name=\"reset\" value=\"1\"><input type=\"submit\" value=\"Reset Database\"></form>";
echo '</font></center><br />';
}elseif(($error) == ("0")){
echo '<br /><br /><center><font color="green">PHPeasynews installed successfully.</font><br /><br /><b>Security Risk:</b> Please now delete install.php.<br /><br />';
}

// Page Ended

// Calling Footer
require("includes/footer.php");
?>
