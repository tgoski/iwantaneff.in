<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: editfeed.php
 * Version: 1.0
 */

include 'header.php';
include 'conf.php';

echo '<div id="content">';

//get variables from address bar
$oldtitle = $_GET['oldtit'];
$oldurl = $_GET['oldurl'];

$newtitle = $_GET['newtitle'];
$newurl = $_GET['newurl'];

//update database with new data
$sql = "UPDATE Feeds SET Title = '$newtitle', Url = '$newurl' WHERE Title = '$oldtitle';";
mysql_query($sql,$con);

//redirect to admin page
js_redirect('admin.php',0);

include 'footer.php';

?>
