<?php

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

function get_coub_video_link($html, $pageUrl)
{
	$doc = new DOMDocument();
	libxml_use_internal_errors(true);
	@$doc->loadHTML($html); // loads your HTML
	$xpath = new DOMXPath($doc);
	// returns a list of all links with rel=nofollow
	$nlist = $xpath->query("//script[@id='coubPageCoubJson']");
	
	$potJsonStr = '';
	foreach($nlist as $node){
		$potJsonStr .= "{$node->nodeName} - {$node->nodeValue}";
	}
	
	$potJsonStr = substr($potJsonStr, 10);
	
	$jsonStr = json_decode($potJsonStr, true);
	
	if(array_key_exists('video', $jsonStr["file_versions"]["html5"])){
		$pageUrl = $jsonStr["file_versions"]["html5"]["video"]["high"]["url"];
	  return $pageUrl;
	} else if(array_key_exists('url', $jsonStr["file_versions"]["iphone"])){
		$pageUrl = $jsonStr["file_versions"]["iphone"]["url"];
	  return $pageUrl;
	}

}

?>
