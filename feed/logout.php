<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: logout.php
 * Version: 1.0
 */

// set the expiration date to one hour ago
setcookie("feedz", "", time()-3600);

include 'header.php';

//redirect to the home page
js_redirect('index.php',0);

echo '</body>';
echo '</html>';

?>