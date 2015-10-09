<?php

$myCoubText = 0;

//$myCoubText = urlencode($_POST["coubText"]);
//$myOrderBy = $_POST["orderBy"];
$myCoubText = 'rocket';
$myOrderBy = 'newest_popular';

function remote_get_contents($url)
{
    if (function_exists('curl_get_contents') AND function_exists('curl_init')) {  
        return curl_get_contents($url);
    } else {  
        return file_get_contents($url);
    }
}
function curl_get_contents($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

$coubApiUrl = "http://coub.com/api/v2/search?q=".$myCoubText."&order_by=".$myOrderBy;
$coubSearchResp = remote_get_contents($coubApiUrl);

echo $coubSearchResp;

$fp = fopen('json/coubs.json', 'w');
fwrite($fp, $coubSearchResp);
fclose($fp);

?>
