<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: installdb.php
 * Version: 1.0
 */

include 'installheader.php';

//get the variables passed
$new_username = $_POST["uname"];
$new_password = $_POST["pass"];
$new_passwordtwo = $_POST["passtwo"];

//error check the variables
if ($new_password != $new_passwordtwo) {
    js_redirect('install.php?error=1',0);
} else if ($new_username == '') {
        js_redirect('install.php?error=2',0);
    } else if ($new_password == '') {
            js_redirect('install.php?error=3',0);
        } else {

            include 'conf.php';
            $new_password = md5($new_password);

            //setup users
            $sql = "CREATE TABLE Users(Username text,Password text)";
            mysql_query($sql,$con);

            $sql = "INSERT INTO Users (Username,Password) VALUES('$new_username','$new_password');";
            mysql_query($sql,$con);

            //setup feeds
            $sql = "CREATE TABLE Feeds(Title text,Url text)";
            mysql_query($sql,$con);

            $sql = "INSERT INTO Feeds (Title,Url) VALUES('Luke Browning','http://www.lukebrowning.com/feed/');";
            mysql_query($sql,$con);

            //setup settings
            $sql = "CREATE TABLE Settings(Feedcount INT, Title text, Favicon boolean)";
            mysql_query($sql,$con);

            $sql = "INSERT INTO Settings (Feedcount, Title, Favicon) VALUES('50', 'Feedz', '0');";
            mysql_query($sql,$con);

            //close connection
            mysql_close($con);

            //redirect to login page
            js_redirect('login.php',0);
        }

echo '</body>';
echo '</html>';

?>