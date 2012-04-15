<?php

/*
 * Title: Feedz RSS Reader
 * Description: Fetch RSS feeds from numerous sites and display them on one page
 * Author: Luke Browning
 * Page: installheader.php
 * Version: 1.0
 */

echo '<html>';
echo '<head>';

//set title
echo '<title>Feedz</title>';
echo '<link rel="stylesheet" href="style.css">';
?>

<script language="javascript" type="text/javascript">
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
