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

news.php file
*/

// Telling CSS not to include the traditional body tags on this page, otherwise it ruins the website its included on
$nobody = "1";

// Require Header File
require("includes/header.php");
// Close head open body
echo '</head><body>';

// Print a notice that DEBUG is on if its on - for security reasons
if(($debug) == ("1")){
echo '<b><font color="red">Warning: Debug Mode ON</font></b><br><br>';
}
echo '<div id="penbody">';

// Make the constant a variable for ease of use
$PEN_DB_TABLE = PEN_DB_TABLE;

// Query
$query = "SELECT * FROM $PEN_DB_TABLE ORDER BY id DESC LIMIT $pen_newsnum";

// If DEBUG is on then print the query above - Useful if somethings not working
if(($debug) == ("1")){
echo "<b>Query:</b> $query";
}

// Select Database
mysql_select_db(PEN_DB_NAME);

// Result
$result = mysql_query ($query);

// Start a table
echo '<table width="80%">';

// While statement

while ($Row = mysql_fetch_array ($result)){


// Start of emotions...

$main = explode("]", $Row[main]);

$count = count($main);

if(($count) > ("2")){
$thenum = "1";
$string = "";
while(($thenum) < ($count)){
if(($thenum) == ("1")){
$string = "$main[$thenum]";
}else{
$string = "$string]$main[$thenum]";
}
$thenum++;
}
}else{
$string = $main[1];
}

$main[1] = $string;

if(($main[0]) == ("[EMOTIONS=0")){
$translate = $main[1];
}elseif(($main[0]) == ("[EMOTIONS=1")){

$translate = $Row[headline];

// Call emotions...
require("includes/emotions/emotions.php");

$Row[headline] = $translate;

$translate = $main[1];

// Call emotions...
require("includes/emotions/emotions.php");



$Row[main] = $translate;

}else{


$translate = $Row[headline];

// Call emotions...
require("includes/emotions/emotions.php");

$Row[headline] = $translate;

$translate = $Row[main];

// Call emotions...
require("includes/emotions/emotions.php");

}

$Row[main] = $translate;

// End emotions

echo '<tr>';
echo "<td class=\"pennewsheader\">$Row[headline]</td>";
echo '</tr>';

echo '<tr>';
echo "<td class=\"pentablemain\"><small>Posted on <font color=\"#878787\">$Row[date]</font> at <font color=\"#878787\">$Row[time]</font> by <font color=\"#878787\">$Row[author]</font></small><br><br>$Row[main]<br><br><a href=\"$pen_siteurl/$pen_includepath/newsarchive.php\" class=\"penhyperlink\">[Newsarchive]</a>";
if(($access) == ("1")){
echo " | <a href=\"$pen_siteurl/$pen_includepath/edit.php?postid=$Row[id]\" class=\"penhyperlink\">[Edit]</a>";
}
echo '</td></tr>';

}

// Close While

// Close Table started just before the while statement
echo '</table>';

// Close mySQL Connection

mysql_close();

echo '<center><br /><br />';

if(($access) == ("1")){
echo "<a href=\"$pen_siteurl/$pen_includepath/admin.php\" class=\"penhyperlink\">[Admin Menu]</a> | <a href=\"$pen_siteurl/$pen_includepath/admin.php?part=logout\" class=\"penhyperlink\">[Log Out]</a>";
}else{
echo "<a href=\"$pen_siteurl/$pen_includepath/admin.php\" class=\"penhyperlink\">[Admin]</a>";
}

echo '</center>';

print("</div>");

echo '</div>';

// Calling Footer
require("includes/footer.php");

// End Page
?>
