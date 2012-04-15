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
require_once 'functions.php';

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

    //how many items from each feed
    $sql = "SELECT * FROM Settings";
    $result = mysql_query($sql,$con);

    while($row = mysql_fetch_assoc($result)) {
        $feedcount = $row['Feedcount'];
        $title = $row['Title'];
        $fav = $row['Favicon'];
    }



    //output site title
    echo '<div id="head"><a href="http://iwantaneff.in/">r</a></div><br />';
    echo '<div id="content">';

    echo '<div id="breadcrumbs">';
    echo '<div id="breadcrumblinks">';

    echo '<div id="bold">Feeds</div> ';

    //get feed addresses
    $result = mysql_query("SELECT * FROM Feeds") or die(mysql_error());

    //echo out feed titles database
    while($row = mysql_fetch_array( $result )) {
        echo '&raquo; <a href="#' . $row['Title'] . '">' . $row['Title'] . '</a> ';
    }
    echo '</div>';
    echo '</div>';

    echo '<div id="feed">';
    echo '<ul>';

    //get feed addresses
    $result = mysql_query("SELECT * FROM Feeds") or die(mysql_error());

    //initialise counter for each group of feeds
    $i = 0;

    //echo out feed titles database
    while($row = mysql_fetch_array( $result )) {

    //calculate id of group
        $valu = "'grp$i'";
        echo '<div id="feedhead">';

        //set link to url
        $link = $row['Url'];

        //get favicon
        if ($ic = getFavicon($link)){
            $fv = true;
        } else {
            $fv = false;
        }

        //show/hide group link
        echo '<li><div id="h">';
        if ($fv && $fav){
            echo '<img class="favico" src="' . $ic . '" />';
        }
        echo '<a href="#" onclick="showhide(' . $valu . ')"; title="Show/Hide" name="' . $row['Title'] . '">' . $row['Title'] . '</a></div></li>';

        echo '';
        echo '</div>';

        echo '<div id="feeds">';
        echo '<div id="grp' . $i . '">';
        echo '<br />';
        echo '<ul>';

        //output feeds for group
        echo @ getFeed("$link", $feedcount);

        //end table
        echo "</ul>";
        echo '<br />';
        echo '</div>';
        echo '</div>';

        //increment counter
        $i++;
    }

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

}
?>