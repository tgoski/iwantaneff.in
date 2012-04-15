<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: conf.php
 * Version: 1.0
 */

//mySQL database settings
$host = 'higgoadmin.db.8642489.hostedresource.com'; //normally localhost
$username = 'higgoadmin'; //database username
$password = 'popeyexox1A'; //database password
$database = 'higgoadmin'; //database

//connect to database
$con = @ mysql_connect($host,$username,$password);
if (!$con) {
//echo ('Could not connect: ' . mysql_error());
}

//select database
@ mysql_select_db($database, $con);

?>