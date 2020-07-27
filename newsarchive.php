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

newsarchive.php file
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


// See if the post variable is empty or not provided
// Just an extra few lines of code thats needed if register globals is off.

if (isset($_GET['post'])) {
   $post = $_GET['post'];
   $post = stripslashes($post);
   $worked = 'TRUE';
} else {
   $post = 'NULL';
   $worked = 'NULL';
}

// Just carrying on the variable check. Does $post = "" ?
if(($post) == ("")){
$post = 'NULL';
$worked = 'NULL';
}

// Right now lets start the page
// Echo the header

echo '<center><b>PHPeasynews</b><br>News Archive</center>';

// If some var stuff worked above then do the majority of the page
if(($worked) == ("TRUE")){
echo '<center><br>Post ID: <b>'. $post .'</b><br><br></center>';
}else{
echo '<br><br>';
}
if(($post) != ("NULL")){


// Make the constant a variable for ease of use
$DB_TABLE = PEN_DB_TABLE;


// Query
$query = "SELECT * FROM $DB_TABLE WHERE id=$post LIMIT 1";

// Debugging - If debug is on print the query above
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


echo '<tr>';
echo '<td class="pennewsheader">';
echo "$Row[headline]";
if(($access) == ("1")){
echo " - <a href=\"$pen_siteurl/$pen_includepath/edit.php?postid=$Row[id]\" class=\"penhyperlink\">[Edit]</a>";
}
echo '</td>';
echo '</tr>';

echo '<tr>';
echo "<td class=\"pentablemain\">
<small>Posted on <div class=\"pennewsarchive\">$Row[date]</div> at <div class=\"pennewsarchive\">$Row[time]</div> by <div class=\"pennewsarchive\">$Row[author]</div></small>

<br><br>$Row[main]</td>";

echo '</tr>';

}

// Close While

// End the table started above
echo '</table>';

// Close mySQL Connection


print("</div>");

}else{
// Query

$DB_TABLE = PEN_DB_TABLE;
$query = "SELECT * FROM $DB_TABLE ORDER BY id";

// Print Query Above if debug = 1
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
echo '<tr>';
echo "<td class=\"pennewsheader\">News Headlines</td>";
echo '</tr>';
while ($Row = mysql_fetch_array ($result)){

echo '<tr>';
echo '<td class="pennewsarchive">';
echo '<a href="newsarchive.php?post=';
echo $Row[id];
echo '" class="penhyperlink">';
echo "$Row[headline]";
echo '</a>';
echo ' - ';
if(($access) == ("1")){
echo "<a href=\"$pen_siteurl/$pen_includepath/edit.php?postid=$Row[id]\" class=\"penhyperlink\">[Edit]</a> - ";
}
echo 'written by <font color="';
echo "$na_authordatetime\"> $Row[author]";
echo '</font> on';
echo '<font color="';
echo "$na_authordatetime\"> $Row[date]";
echo '</font> at';
echo '<font color="';
echo "$na_authordatetime\"> $Row[time]";
echo '</font></td>';
echo '</tr>';

}
// End the table started above
echo '</table>';
}
mysql_close();

echo '<center><br /><br />';

if(($access) == ("1")){
echo "<a href=\"$pen_siteurl/$pen_includepath/admin.php\" class=\"penhyperlink\">[Admin Menu]</a> | <a href=\"$pen_siteurl/$pen_includepath/admin.php?part=logout\" class=\"penhyperlink\">[Log Out]</a>";
}else{
echo "<a href=\"$pen_siteurl/$pen_includepath/admin.php\" class=\"penhyperlink\">[Admin]</a>";
}

echo '</center>';

// Calling Footer
require("includes/footer.php");

// End Page
?>
