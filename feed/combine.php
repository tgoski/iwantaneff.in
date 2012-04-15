<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: index.php
 * Version: 1.0
 */

include 'connection.php';
include 'header.php';

//make sure we use my rss library
require_once("rss.php");

//if we havn't had an database error
if ($ferror == false) {

//check if we're logged in any if any cookies are set
    if (isset($_COOKIE["feedz"])) {
        $user = $_COOKIE["feedz"];
        $logged_in = true;
    } else {
        $logged_in = false;
    }

    //Welcome note
    echo '<div id="menu">';
    if ($logged_in == true) {
        echo 'Welcome, ' . $user . '! <a href="admin.php">Administration</a> | <a href="logout.php">Log Out</a>';
    } else {
        echo 'Welcome, Guest! <a href="login.php">Log In</a>';
    }

    //how many items from each feed
    $sql = "SELECT * FROM Settings";
    $result = mysql_query($sql,$con);

    while($row = mysql_fetch_assoc($result)) {
        $feedcount = $row['Feedcount'];
        $title = $row['Title'];
    }

    echo '</div>';

    //output site title
    echo '<div id="head">' . $title . '</div><br />';
    echo '<div id="content">';

    echo '<div id="breadcrumbs">';
    echo '<div id="breadcrumblinks">';

    echo '<div id="bold">Feeds</div> ';

    echo '</div>';
    echo '</div>';

    echo '<div id="feed">';
    echo '<ul>';

    //calculate id of group
        echo '<div id="feedhead">';

        //show/hide group link
        echo '<li><div id="h">Combined Feed</div></li>';

        echo '';
        echo '</div>';

        echo '<div id="feeds">';
        echo '<div id="grp1">';
        echo '<br />';
        echo '<ul>';

        //set link to url
        $link = $row['Url'];

        //output feeds for group
        echo @ combineFeeds(10);

        //end table
        echo "</ul>";
        echo '<br />';
        echo '</div>';
        echo '</div>';


    echo '</ul>';
    echo '</div>';

    include 'footer.php';

} else {

//if database error...
    echo '<div id="menu">';
    echo '';
    echo '</div>';

    echo '<div id="head">Install</div><br />';

    echo '<div id="content">';

    echo '<div id="breadcrumbs">';
    echo '<div id="breadcrumblinks">';

    echo '<div id="bold">Install</div> &raquo; ';
    echo '</div>';
    echo '</div>';

    echo '<div id="er"><br />You must run the <a href="install.php">Installer</a> First!<br /><br /></div>';

    echo '<div id="foot">';
    echo '<div id="notice">&copy <a href="http://www.lukebrowning.com/">Luke Browning</a> - <a href="combine.php">Combined Output</a> - <a href="index.php">Separated Output</a></div>';
    echo '</div>';
}
?>