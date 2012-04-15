<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: login.php
 * Version: 1.0
 */

$logged_in = false;

if (isset($_COOKIE["feedz"])) {
    $logged_in = true;
} 

include 'header.php';

//if user is logged in redirect to admin page...
if ($logged_in == true) {
    js_redirect('admin.php',0);;
} else {

//...else provide a login form
    echo '<div id="menu">';
    echo '';
    echo '</div>';

    echo '<div id="head">Login</div><br />';

    echo '<div id="content">';

    echo '<div id="breadcrumbs">';
    echo '<div id="breadcrumblinks">';

    echo '<div id="bold">Administration</div> ';
    echo '&raquo; Login';
    echo '</div>';
    echo '</div>';

    echo '<div id="container"><br />';

    //login form
    echo '<form action="admin.php" method="post">';
    echo '<fieldset><legend>Login</legend>';
    echo '<label for="name">Username:</label>';
    echo '<input type="text" name="name" /><br />';
    echo '<label for="pass">Password:</label>';
    echo '<input type="password" name="pass" /><br />';
    echo '<label for="remember">Remember Me:</label>';
    echo '<input type="checkbox" name="remember" /><br /><br />';
    echo '<input type="submit" value="Login" /><br />';
    echo '</fieldset>';
    echo '</form>';
    echo '<br />';
    echo '</div>';

    //echo '<a href="index.php"> << Back</a>';

    echo '<div id="foot">';
    echo '<div id="notice">&copy <a href="http://www.lukebrowning.com/">Luke Browning</a></div>';
    echo '</div>';
}

echo '</body>';
echo '</html>';

?>