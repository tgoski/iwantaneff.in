<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: install.php
 * Version: 1.0
 */

include 'installheader.php';
require_once 'conf.php';

//if there has been an error, get the error code
$errornumber = $_GET['error'];

echo '<div id="menu">';
echo '';
echo '</div>';

echo '<div id="head">Install</div><br />';
echo '<div id="content">';

echo '<div id="breadcrumbs">';
echo '<div id="breadcrumblinks">';

echo '<div id="bold">Installation</div> ';
echo '&raquo; Setup';
echo '</div>';
echo '</div>';

//select database
@ mysql_select_db($database, $con);

$myerror = false;

//check some database error codes
if (mysql_errno() == 1049) {
    echo('<br />Database Error: Database \'' .$database . '\' doesn\'t exist! Please create this before installing!<br />');
    $myerror = true;
} else if (mysql_errno()) {
        echo '<br />MySQL Database Error: Please check you connection details in conf.php<br />';
        $myerror = true;
    }

//if its not a database error, is it a human error?
if ($errornumber == 1) {
    echo '<br /><div id="error">Passwords did not match!</div>';
} else if ($errornumber == 2) {
        echo '<br /><div id="error">Username was blank!</div>';
    } else if ($errornumber == 3) {
            echo '<br /><div id="error">Password was blank!</div>';
        }

//if theres no database error
if ($myerror == false) {
    echo '<br /><div id="container">';
    echo '<form action="installdb.php" method="post">';
    echo '<fieldset><legend>Install</legend>';
    echo '<label for="uname">Username:</label>';
    echo '<input type="text" name="uname" /><br />';
    echo '<label for="pass">Password:</label>';
    echo '<input type="password" name="pass" /><br />';
    echo '<label for="passtwo">Retype Password:</label>';
    echo '<input type="password" name="passtwo" /><br />';
    echo '<input type="submit" value="Install" />';
    echo '</fieldset>';
    echo '</form>';
}

echo '</div><br />';


echo '<div id="foot">';
echo '<div id="notice">&copy <a href="http://www.lukebrowning.com/">Luke Browning</a></div>';
echo '</div>';

echo '</div>';
echo '</body>';
echo '</html>';

?>