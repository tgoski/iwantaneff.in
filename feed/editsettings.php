<?php

include 'header.php';
include 'conf.php';

echo '<div id="content">';

$show = $_GET['show'];
$old = $_GET['oldcount'];

$newtitle = $_GET['title'];
$oldtitle = $_GET['oldtitle'];

$newfav = $_GET['newfav'];
$oldfav = $_GET['oldfav'];

if ($newfav == 'on') {
    $newfav = 1;
}

if ($show > 0 && $show < 100) {

    $sql = "UPDATE Settings SET Feedcount = '$show' WHERE Feedcount = '$old';";
    mysql_query($sql,$con);

    $sql = "UPDATE Settings SET Title = '$newtitle' WHERE Title = '$oldtitle';";
    mysql_query($sql,$con);

    $sql = "UPDATE Settings SET Favicon = '$newfav' WHERE Favicon = '$oldfav';";
    mysql_query($sql,$con);

    js_redirect('admin.php',0);

} else {
    js_redirect('admin.php?op=7',0);
}

include 'footer.php';

?>
