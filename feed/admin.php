<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: admin.php
 * Version: 1.0
 */

$user = $_POST["name"];
$pass = $_POST["pass"];
$remember = $_POST["remember"];

//hash password
$pass = md5($pass);

include 'connection.php';

//ask database for users that match the credentials given
$sql = "SELECT * FROM Users WHERE Username='$user' AND Password='$pass';";
$result = mysql_query($sql,$con);
$num_rows = mysql_num_rows($result);

//if no cookie is set, set one
if (isset($_COOKIE["feedz"])) {
    $user = $_COOKIE["feedz"];
} 

//function to redirect
function js_redirect($url, $seconds=5) {
    echo "<script language=\"JavaScript\">\n";
    echo "<!-- hide code from displaying on browsers with JS turned off\n\n";
    echo "function redirect() {\n";
    echo "window.location = \"" . $url . "\";\n";
    echo "}\n\n";
    echo "timer = setTimeout('redirect()', '" . ($seconds*1000) . "');\n\n";
    echo "-->\n";
    echo "</script>\n";
    return true;
}

//if the user exists or the user is already logged in
if (($num_rows > 0) || isset($_COOKIE["feedz"])) {
//set cookie for an hour
    $logged_in = true;
    if ($remember == true) {

    //set a cookie to remember the user forever
        setcookie("feedz", $user, time()+3600*24*999);
    } else {

    //set a cookie just for this session
        setcookie("feedz", $user, 0);
    }

} else {
//redirect to the login page as credentials were incorrect
    js_redirect('login.php',0);
}

//instead of including the header
echo '<html>';
echo '<head>';
echo '<title>Feedz</title>';
echo '<link rel="stylesheet" href="style.css">';
echo '</head>';
echo '<body>';
echo '<div id="menu">';

//Welcome note
if ($logged_in == true) {
//content
    echo "Welcome, " . $user . "! <a href=\"index.php\">Home</a> | <a href=\"logout.php\">Logout</a>";
}

echo '';
echo '</div>';

echo '<div id="head">Administration</div><br />';
echo '<div id="content">';

//what page should we be at?
$op = $_GET["op"];

//breadcrumb links
echo '<div id="breadcrumbs">';
echo '<div id="breadcrumblinks">';

echo '<div id="bold">Administration</div> ';

//generate breadcrumb
if ($op == 0) {
    echo '&raquo; <a href="admin.php?op=0">My Feeds</a>';
} else if ($op == 1) {
        echo '&raquo; <a href="admin.php?op=0">My Feeds</a> &raquo; <a href="admin.php?op=1">Add Feed</a>';
    } else if ($op == 2) {
            echo '&raquo; <a href="admin.php?op=0">My Feeds</a> &raquo; Delete Feed?';
        } else if ($op == 3) {
                echo '&raquo; <a href="admin.php?op=3">About</a>';
            } else if ($op == 4) {
                    echo '&raquo; <a href="admin.php?op=0">My Feeds</a> &raquo; Feed Deleted!';
                } else if ($op == 5) {
                        echo '&raquo; <a href="admin.php?op=0">My Feeds</a> &raquo; Edit Feed';
                    } else if ($op == 6) {
                            echo '&raquo; <a href="admin.php?op=0">My Feeds</a> &raquo; Settings';
                        } else if ($op == 7) {
                                echo '&raquo; <a href="admin.php?op=0">My Feeds</a> &raquo; Settings';
                            }

echo '</div>';
echo '</div>';

//admin menu
echo '<div id="adminmenu">';
echo '<a href="admin.php?op=0">My Feeds</a> &nbsp; &bull; &nbsp; <a href="admin.php?op=6">Settings</a> &nbsp; &bull; &nbsp; <a href="admin.php?op=3">About</a>';
echo '</div>';
echo '<br />';

//if the installer still exists, ask to remove
if (file_exists('install.php')) {
    echo '<div id="#errorcontainer">';
    echo '<div id="error">';
    echo 'Please remove the install.php and installdb.php file\'s from the root directory! With these file\'s still in place anyone can create an administrator account!';
    echo '</div>';
    echo '<br /></div>';
}

//show the page
switch($op) {
//My Feeds
    case 0:

        echo '<div id="feedstable">';

        //get all feeds
        $result = mysql_query("SELECT * FROM Feeds") or die(mysql_error());

        //start table
        echo '<table id="feedtable" border="0">';
        echo '<tr> <th>Title</th> <th>URL</th> <th>Edit</th> <th>Delete</th> </tr>';

        //echo out feeds in database
        while($row = mysql_fetch_array( $result )) {

        // echo out the contents of each row into a table
            echo '<tr id="item"><td>';
            echo $row['Title'];
            echo '</td><td id="link">';
            echo '<a href="' . $row['Url'] . '">' . $row['Url'] . '</a>' ;
            echo '</td><td id="icon">';
            echo '<a href="admin.php?op=5&oldtit=' . $row['Title'] . '&oldurl='. $row['Url'] .'"><img src="images/edit.png" border="0" title="Edit ' . $row['Title'] . '" /></a>';
            echo '</td><td id="icon">';
            echo '<a href="admin.php?op=2&deltit=' . $row['Title'] . '&delurl='. $row['Url'] .'"><img src="images/delete.png" border="0" title="Delete ' . $row['Title'] . '" /></a>';
            echo "</td></tr>";
        }

        //end table
        echo "</table><br />";

        //add new feed link
        echo '<div id="btncontain"><div id="newfeed"><a href="admin.php?op=1">Add Feed</a></div></div>';

        echo '<br /><br /></div>';

        break;

    //Add Feeds
    case 1:

    //form to add a new feed
        echo '<div id="container">';
        echo '<form action="addfeed.php" method="get">';
        echo '<label for="title">Title:</label>';
        echo '<input type="text" name="title" /><br />';
        echo '<label for="url">URL:</label>';
        echo '<input type="text" name="url" /><br />';
        echo '<input type="submit" value="Add" />';
        echo '</form>';
        echo '</div>';

        break;

    //Remove Feeds
    case 2:

        echo '<div id="deletefeed">';

        $title = $_GET['deltit'];
        $url = $_GET['delurl'];

        //check if we should delete feed
        echo 'Are you sure you want to delete <b>' . $title . '</b>?<br /><br />';
        echo '<a href="admin.php?op=4&deltit=' . $title . '&delurl=' . $url . '">Yes</a> <a href="admin.php">No</a>';
        echo '</div><br />';

        break;

    //About
    case 3:

    //about box
        echo '<div id="about">';
        echo 'Feedz RSS Reader &copy Luke Browning 2010<br /><br />Support Via <a href="http://www.lukebrowning.com/">www.lukebrowning.com</a>';
        echo '</div><br />';

        break;

    //Remove feed
    case 4:

        echo '<div id="feeddeleted">';

        $title = $_GET['deltit'];
        $url = $_GET['delurl'];

        //delete from database
        $sql = "DELETE FROM Feeds WHERE Title='$title' AND Url='$url';";
        mysql_query($sql,$con);

        echo 'Feed Deleted!';
        echo '</div><br />';

        //redirect to admin page
        js_redirect('admin.php',3);

        break;

    //edit feed
    case 5:

        $title = $_GET['oldtit'];
        $url = $_GET['oldurl'];

        //form to edit feed details
        echo '<div id="container">';
        echo '<form action="editfeed.php" method="get">';
        echo '<fieldset><legend>Edit Feed</legend>';
        echo '<input type="hidden" name="oldtit" value="' . $title . '" />';
        echo '<input type="hidden" name="oldurl" value="' . $url .'"/>';
        echo '<label for="newtitle">Title:</label>';
        echo '<input type="text" name="newtitle" value="' . $title . '" /><br />';
        echo '<label for="newurl">URL:</label>';
        echo '<input type="text" name="newurl" value="'.$url.'" /><br />';
        echo '<input type="submit" value="Save Changes" />';
        echo '</fieldset>';
        echo '</form>';
        echo '<br />';
        echo '</div>';

        break;

    //settings
    case 6:

        echo '<div id="warning">Please note that \'Feed Settings\' will only work if the feed you are fetching is set up correctly. ' .
            'Some sites only return a set number of items whilst others will return however many you request.</div><br />';

        echo '<div id="container">';

        //get settings
        $sql = "SELECT * FROM Settings";
        $result = mysql_query($sql,$con);

        //get data from database
        while($row = mysql_fetch_assoc($result)) {
            $feedcount = $row['Feedcount'];
            $apptitle = $row['Title'];
            $fav = $row['Favicon'];
        }

        //form to make changes to settings
        echo '<form action="editsettings.php" method="get">';
        echo '<fieldset><legend>Feed Settings</legend>';
        echo '<input type="hidden" name="oldcount" value="' . $feedcount . '" />';
        echo '<label for="show">Feeds to Show (1 - 100):</label>';
        echo '<input type="text" name="show" value="' . $feedcount . '" /><br />';
        echo '</fieldset>';
        echo '<br />';
        echo '<fieldset><legend>Application Settings</legend>';
        echo '<input type="hidden" name="oldtitle" value="' . $apptitle . '" />';
        echo '<input type="hidden" name="oldfav" value="' . $fav . '" />';
        echo '<label for="title">Title:</label>';
        echo '<input type="text" name="title" value="' . $apptitle . '" /><br />';
        echo '<label for="newfav">Show Favicon:</label>';
        echo '<input type="checkbox" name="newfav" ';
        if ($fav == 1) {
            echo 'checked';
        }
        echo ' /><br />';
        echo '</fieldset>';
        echo '<br /><input type="submit" value="Save Changes" />';
        echo '</form>';
        echo '<br />';

        echo '</div>';

        break;

    //settings error
    case 7:

        echo '<div id="error">Invalid Input! Please enter a value between 1 and 100</div>';
        echo '<br />';

        //redirect back to settings
        js_redirect('admin.php?op=6',3);

        break;

    //any other option
    default:

    //the user has altered the url and the page doesnt exist, redirect to the main admin page
        echo 'Sorry, this page does not exist! You will be re-directed back to the main administration page in 3 seconds.';
        js_redirect('admin.php',0);
        break;
}

include 'footer.php';

?>