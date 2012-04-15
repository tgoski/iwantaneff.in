<?php

/*
 * Title: getRSS
 * Author: Luke Browning
 * Description:	Get a defined amount of posts from an rss
 * 		feed and output the title and the date it
 *		was published. Can be combined into one
 *              feed or output separately.
 * Version: 1.2
 */

//calculate how long ago a post was made
function countTime($newdate) {

//get current date
    $now = date('Y-m-d H:i:s');
    
    //differences between times
    $number_of_seconds = (strtotime($now) - strtotime($newdate));
    $number_of_minutes = $number_of_seconds / (60);
    $number_of_hours = $number_of_minutes / (60);
    $number_of_days = $number_of_hours / (24);
    $number_of_days_to_display = intval($number_of_days);
    $number_of_hours_to_display = intval($number_of_hours);
    $number_of_minutes_to_display = intval($number_of_minutes - ($number_of_hours_to_display * 60));
    $number_of_seconds_to_display= intval($number_of_seconds - ($number_of_minutes_to_display * 60 * 60) - ($number_of_hours_to_display * 60));
    
    //calculate what to return
    if ($number_of_days_to_display > 0) {
        return $number_of_days_to_display.' days ago';
    } else if ($number_of_hours_to_display == 1) {
            return $number_of_hours_to_display.' hour, '.$number_of_minutes_to_display.' minutes ago';
        } else if ($number_of_hours_to_display > 1) {
                return $number_of_hours_to_display.' hours, '.$number_of_minutes_to_display.' minutes ago';
            } else if ($number_of_minutes_to_display > 0) {
                    return $number_of_minutes_to_display.' minutes ago';
                } else if ($number_of_minutes_to_display < 0) {
                        return 'Less than a minute ago';
                    }
}

//gets all feeds
function getFeed($url, $size) {

//load feed into xml element
    $rss = simplexml_load_file($url);
    
    //keep track of how many posts we've output so we can limit this
    $count = 0;
    
    if($rss) {
    
    //get items
        $items = $rss->channel->item;
        
        //go through each itme and output title and length of time since it was posted
        foreach($items as $item) {
            if ($count < $size) {
                $title = strip_tags($item->title);
                $link = strip_tags($item->link);
                $published_on = strip_tags($item->pubDate);
                $published_on = date('Y-m-d H:i:s', strtotime($published_on));
                $d = countTime($published_on);
                echo '<li><a href="'.$link.'">'.$title.'</a> <div class="date"> - ' . $d . '</div></li>';
                $count++;
            }
        }
    }
}

//function to sort posts by date for combinedFeeds()
function sortbydate($a, $b) {
    if($a['date'] < $b['date'])
        return 1;
    if($a['date'] > $b['date'])
        return -1;
    return 0;
}

//combine multiple sources into one feed
function combineFeeds($size) {

    $feeds = array();

    //get all feeds
    $result = mysql_query("SELECT * FROM Feeds") or die(mysql_error());
    
    //echo out feeds in database
    while($row = mysql_fetch_array( $result )) {
        $temparr =  array("url" => $row['Url'] , "title" => $row['Title']);
        array_push($feeds, $temparr);
    }
        
        $postarray = array();
        
        foreach ($feeds as $feed) {
        
        //load feed into xml element
            $rss = simplexml_load_file($feed["url"]);
            
            //keep track of how many posts we've output so we can limit this
            $count = 0;
            
            if($rss) {
            
            //get items
                $items = $rss->channel->item;
                
                //go through each itme and output title and length of time since it was posted
                foreach($items as $item) {
                    if ($count < $size) {
                        $title = strip_tags($item->title);
                        //$title = str_replace (" ", "%20", $title);
                        $link = strip_tags($item->link);
                        $published_on = strip_tags($item->pubDate);
                        $published_on = date('Y-m-d H:i:s', strtotime($published_on));
                        //$d = countTime($published_on);
                        $temparr = array("posttitle" => $title, "postlink" => $link, "date" => $published_on, "via" => $feed["title"]);
                        array_push($postarray,$temparr);
                        $count++;
                    }
                }
            }
            
        }
        
        usort($postarray, 'sortbydate');
        $count = 0;
        
        foreach ($postarray as $post) {
            if($count < $size) {
                $d = countTime($post["date"]);
                $link = str_replace (" ", "%20", $post["postlink"]);
                echo '<li><a href="'. $link . '">' . $post["posttitle"] . '</a> <div class="date">' . $d . ' via ' . $post["via"] .'</div>' . '</li>';
                $count++;
            }
        }
    //print_r($postarray);
    }
    
    //gets a post
    function getDescription($url, $title_to_find) {
    
    //load feed into xml element
        $rss = simplexml_load_file($url);
        
        if($rss) {
        
        //get items
            $items = $rss->channel->item;
            
            //go through each item and output title and length of time since it was posted
            foreach($items as $item) {
                $title_to_find = strip_tags($title_to_find);
                $title_to_find = preg_replace("/[^a-zA-Z0-9\s]/", "", $title_to_find);
                $title = strip_tags($item->title);
                $title = preg_replace("/[^a-zA-Z0-9\s]/", "", $title);
                if ($title == $title_to_find) {
                    $title = strip_tags($item->title);
                    $link = strip_tags($item->link);
                    $description = strip_tags($item->description);
                    $published_on = strip_tags($item->pubDate);
                    $published_on = date('Y-m-d H:i:s', strtotime($published_on));
                    $d = countTime($published_on);
                    echo '<div id="item"><a href="'.$link.'">'.$title.'</a> <div style="color: #CCC">' . $d . '</div><br />' . $description . '</div>';
                }
            }
        }
    }

?>