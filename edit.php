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

edit.php file
*/
// Require header file
require("includes/header.php");


if (isset($_POST['beensubmitted'])){
$beensubmitted = $_POST['beensubmitted'];
}else{
$beensubmitted = "FALSE";
}

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

if(($access) == ("1")){

echo '<center><B>PHPeasynews<br>Edit Post</b></center><br><br>';
// Right. We need to make sure the user has come from the news.php or newsarchive.php page.
// Otherwise tell them that we do not wish them to visit this page directly

 if(($beensubmitted) == ("TRUE")){
 if (isset($_POST['postid'])){
 $postid = $_POST['postid'];
 }else{
 $postid = "FALSE";
  }
            }else{
            if (isset($_GET['postid'])){
            $postid = $_GET['postid'];
            }else{
            $postid = "FALSE";
            }
            }


// Print a notice if debug is on - so the user knows its on and knows its a security risk
if(($debug) == ("1")){
echo '<b><font color="red">Warning: Debug Mode ON - Will <i>not</i> redirect</font></b><br><br>';
echo 'Site Name: ';
echo $pen_sitename;
echo '<br>Site URL: ';
echo $pen_siteurl;
}

if(($_POST[mode]) == ("delete")){

echo '<fieldset><legend>PHPeasynews - Are you sure?</legend><form action="edit.php" method="post">';
echo '<table><tr><td class="form">Are you sure you want to delete this post?</td></tr>';
echo '<input type="hidden" name="mode" value="deleteconfirm"><input type="hidden" name="postid" value="' . $_POST[postid] . '">';
echo '<tr><td><table><tr><td class="form"><input type="submit" name="confirm" value="Yes"></td><td class="form"><input type="submit" value="No" name="confirm"></td></tr></table></td></tr>';
echo '</table></fieldset>';
echo '<br />';

// Calling Footer
require("includes/footer.php");

exit;
}
if(($_POST[mode]) == ("deleteconfirm")){

if(($_POST[confirm]) == ("Yes")){

// Delete post

// Make the constant a variable for ease of use
$DB_TABLE1 = PEN_DB_TABLE;

$query = "DELETE FROM `$DB_TABLE1` WHERE `id`='$_POST[postid]' LIMIT 1";

if(($debug) == ("1")){
echo "<br><b>Query:</b> $query<br>";
}

mysql_select_db(PEN_DB_NAME);

if(mysql_query ($query)){
echo '<center><font color="green">You have successfully deleted a post from the database.';
echo '</font></center>';
}else{
echo '<center><font color="red">Unfortunatly an error has occured. Please check your config.php settings. If still in doubt contact us.';
echo '</font><br></center>';
}
echo '<center><br />';
echo '<br />';
echo "<a href=\"$pen_siteurl/$pen_includepath/newsarchive.php\" class=\"penhyperlink\">[News Archive]</a>";
echo '<br />';
echo "<a href=\"$pen_siteurl/$pen_includepath/admin.php\" class=\"penhyperlink\">[Admin Menu]</a>";

echo '<br />';
echo '<br /></center>';

// Calling Footer
require("includes/footer.php");

exit;

}else{
// Don't delete...
echo 'Post <b>not</b> deleted';

echo '<center><br />';
echo '<br />';
echo "<a href=\"$pen_siteurl/$pen_includepath/newsarchive.php\" class=\"penhyperlink\">[News Archive]</a>";
echo '<br />';
echo "<a href=\"$pen_siteurl/$pen_includepath/admin.php\" class=\"penhyperlink\">[Admin Menu]</a>";

echo '<br />';
echo '<br /></center>';

// Calling Footer
require("includes/footer.php");

exit;
}
}

// Make the constant a variable for ease of use
$DB_TABLE = PEN_DB_TABLE;

// If page has a post id then do the page
	if(($postid) != ("FALSE")){

		if(($beensubmitted) != ("TRUE")){

  	$query = "SELECT * FROM $DB_TABLE WHERE id=$postid";

  	if(($debug) == ("1")){
  	echo "<br><b>Query:</b> $query<br>";
  	}

		// Select Database
		mysql_select_db(PEN_DB_NAME);

		// Result
		$result = mysql_query ($query);

		// While statement

		while ($Row = mysql_fetch_array ($result)){
		// Assign all the row arrays with values to be used below
  	$headline = $Row['headline'];
		$author = $Row['author'];
  	$main = $Row['main'];
		}
		// Close While
		$main = str_replace("<br>", "<br />", $main);
$main = str_replace("<br />", "\n", $main);
$bmain = $main;

$main = explode("]", $main);

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
$emotions = 0;
$main = $main[1];

}elseif(($main[0]) == ("[EMOTIONS=1")){
$emotions = 1;
$main = $main[1];

}else{

$emotions = 1;
$main = $bmain;
}


  	echo '<fieldset><legend>PHPeasynews - Edit News</legend><form action="edit.php" method="post">';
		echo '<table><tr><td class="form">Headline (title):</td><td>';
		echo '<input type="text" name="headline" value="' . $headline . '"></td></tr>';
		echo '<tr><td class="form">Author:</td>';
     echo '<td><input type="hidden" name="author" value="';
     echo $loggedin_un;
     echo '">';
     echo "<i>$loggedin_un</i>";
     echo '</td></tr>';
		echo '<tr><td class="form">Main News:</td>';
		echo '<td><textarea name="main" cols="40" rows="10">' . $main . '</textarea></td></tr>';
		echo '<input type="hidden" name="beensubmitted" value="TRUE">';
     echo '<input type="hidden" name="postid" value="' . $postid . '">';
     echo '<tr><td></td><Td class="form">Emotions? (Default On, switch off if posting HTML code...) <input type="checkbox" name="emotions" value="1"';
if(($emotions) == ("1")){ echo 'checked'; }
echo ' ></td></tr>';
		echo '<tr><td><input type="submit" value="Modify"></td><td></form><form action="edit.php" method="POST"><input type="hidden" name="mode" value="delete"><input type="hidden" name="postid" value="' . $postid . '"><input type="submit" value="Delete Post"></form></td></tr>';
		echo '</table>';
		echo '</fieldset>';

			}
        if(($beensubmitted) == ("TRUE")){
  		$headline = $_POST['headline'];
			$author = $_POST['author'];
			$main = str_replace("\n", "<br />", $_POST['main']);

        // Make the constant a variable for ease of use
        $DB_TABLE = PEN_DB_TABLE;
        if(($_POST[emotions]) != ("1")){
        $emotions = 0;
        }else{
        $emotions = 1;
        }
        
        $bmain = $main;

$main = explode("]", $main);
$e = explode("=", $main[0]);
if(($e[0]) != ("[EMOTIONS")){
$string = $bmain;
}else{
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
}

}
    
$main = "[EMOTIONS=$emotions]$string";

			$query = "UPDATE $DB_TABLE SET headline='$headline', main='$main', author='$author' WHERE id = '$postid' LIMIT 1";

			// DEBUG

			if(($debug) == ("1")){
			echo "<br><b>Query:</b> $query<br>";
			}

			// END DEBUG

			// Select Database

			mysql_select_db(PEN_DB_NAME);

			// Has it worked?

			if(mysql_query ($query)){
			echo '<center><font color="green">You have successfully edited a News Post in the database.';
			echo '<br><br>';
        echo "<a href=\"$pen_siteurl/$pen_includepath/admin.php\" class=\"penhyperlink\">";
        echo '[Admin Menu]</a></font><br></center>';
			}else{
			echo '<center><font color="red">Unfortunatly an error has occured. Please check your config.php settings. If still in doubt contact us.';
			echo '<br><br>';
        echo "<a href=\"$pen_siteurl/$pen_includepath/admin.php\" class=\"penhyperlink\">";
        echo '[Admin Menu]</a></font><br></center>';
			}

			// If it hasn't been submitted however the passwords match then show the insert form!


			}


	}else{
  echo '<center><font color="red"><b>Error:</b> You have not sumbitted a <i>postid</i> this is most likely due to you not accessing this page via the "[EDIT]" link on the news page. Unless you know the postid (append ?postid=NUMBER to the URL if you do) then we suggest using the link from the news page.</font>';
  }
echo '<br />';
// Page Ended

}else{

echo '<font color="red">You are not logged in.</font>';
echo '<br /><br /><a href="admin.php">[Log In]</a>';

}

// Calling Footer
require("includes/footer.php");

?>
