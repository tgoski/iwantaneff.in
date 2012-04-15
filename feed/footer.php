<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: footer.php
 * Version: 1.0
 */

//close database connection
mysql_close($con);

//close content tag
echo '</div>';

echo '<br />';

echo '<script>';
echo 'window.onload = function(){';
echo 'var links=document.getElementById("feed").getElementsByTagName("a"),';
echo 'len=links.length, i;';
echo 'for (i=len; i--;) { links[i].target="_blank"; }';
echo '}';
echo '</script>';

echo '</body>';
echo '</html>';

?>