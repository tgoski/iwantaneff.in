<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: header.php
 * Version: 1.0
 */
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
echo '<head>';

include 'connection.php';

//fetch settings
$sql = "SELECT * FROM Settings";
$result = @ mysql_query($sql,$con);

//find the app title
while($row = @ mysql_fetch_assoc($result)) {
    $title = $row['Title'];
}

//set title
echo '<title>' . $title . '</title>';
echo '<link rel="stylesheet" href="style.css" />';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
?>

<script type="text/javascript">
    function showhide(id){
        if (document.getElementById){
            obj = document.getElementById(id);
            if (obj.style.display == "none"){
                obj.style.display = "";
            } else {
                obj.style.display = "none";
            }
        }
    }
</script> 

<?php
echo '</head>';
echo '<body>';

//function to redirect
function js_redirect($url, $seconds=5) {
    echo "<script language=\"JavaScript\">\n";
    echo "<!-- hide code from displaying on browsers with JS turned off\n\n";
    echo "function redirect() {\n";
    echo "window.location = \"" . $url . "\";\n";
    echo "}\n\n";
    echo "timer = setTimeout('redirect()', '" . ($seconds*1000) . "');\n\n";
    echo "-->\n";
    echo "</script>\n";
    return true;
}

?>