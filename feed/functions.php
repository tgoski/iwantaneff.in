<?php

function getFavicon($url)  {

    $chunk = 4096;
    $timeout = 2;   // seconds

    $HTTPRequest = @fopen($url, 'r');
    if ($HTTPRequest)  {
        stream_set_timeout($HTTPRequest, $timeout);
        $html = fread($HTTPRequest, $chunk);
        $HTTPRequestData = stream_get_meta_data($HTTPRequest);
        fclose($HTTPRequest);
        if (!$HTTPRequestData['timed_out'])  {
            if (preg_match('/<link[^>]+rel="(?:shortcut )?icon"[^>]+?href="([^"]+?)"/si', $html, $matches))  {
                $linkUrl = html_entity_decode($matches[1]);
                if (substr($linkUrl, 0, 1) == '/')  {
                    $urlParts = parse_url($url);
                    $faviconURL = $urlParts['scheme'].'://'.$urlParts['host'].$linkUrl;
                }
                elseif (substr($linkUrl, 0, 7) == 'http://') $faviconURL = $linkUrl;
                elseif (substr($url, -1, 1) == '/') $faviconURL = $url.$linkUrl;
                else $faviconURL = $url.'/'.$linkUrl;
            }
            else {
                $urlParts = parse_url($url);
                $faviconURL = $urlParts['scheme'].'://'.$urlParts['host'].'/favicon.ico';
            }
            $HTTPRequest = @fopen($faviconURL, 'r');
            if ($HTTPRequest)  {
                stream_set_timeout($HTTPRequest, $timeout);
                $HTTPRequestData = stream_get_meta_data($HTTPRequest);
                fclose($HTTPRequest);
                $request = print_r($HTTPRequestData, true);
                $request = str_replace('Array', '', $request);
                $request = str_replace("\n\n", "\n", $request);
                if (!$HTTPRequestData['timed_out']) return $faviconURL;
            }
        }
    }
    return false;
}

?>
