<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: addfeed.php
 * Version: 1.0
 */

include 'header.php';
include 'conf.php';

echo '<div id="content">';

//get variables from address bar
$title = $_GET['title'];
$url = $_GET['url'];

//insert new data into database
$sql = "INSERT INTO Feeds (Title,Url) VALUES('$title','$url');";
mysql_query($sql,$con);	

//redirect to admin page
js_redirect('admin.php',0);

include 'footer.php';

?>