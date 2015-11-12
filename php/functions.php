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
	// Init DOM document and load it
	$doc = new DOMDocument();
	libxml_use_internal_errors(true);
	@$doc->loadHTML($html); // loads your HTML
	$xpath = new DOMXPath($doc);

	// returns a list of all links with script id='coubPageCoubJson'
	$nlist = $xpath->query("//script[@id='coubPageCoubJson']");
	
	// Put string in JSON like format
	$potJsonStr = '';
	foreach($nlist as $node){
		$potJsonStr .= "{$node->nodeName} - {$node->nodeValue}";
	}
	// Delete first 10 unnecessary characters	
	$potJsonStr = substr($potJsonStr, 10);
	
	// Convert in true JSON
	$jsonStr = json_decode($potJsonStr, true);
	
	// Check for video format and return link for a video
	$pageUrl = array();

	if(array_key_exists("video", $jsonStr["file_versions"]["html5"])){
		$pageUrl["video_high_res_muted"] = $jsonStr["file_versions"]["html5"]["video"]["high"]["url"];
	} 

	if(array_key_exists("video", $jsonStr["file_versions"]["html5"])){
		$pageUrl["video_med_res_muted"] = $jsonStr["file_versions"]["html5"]["video"]["med"]["url"];
	} 

	if(array_key_exists("audio", $jsonStr["file_versions"]["html5"])){
		$pageUrl["audio_high_res"] = $jsonStr["file_versions"]["html5"]["audio"]["high"]["url"];
	} 

	if(array_key_exists("audio", $jsonStr["file_versions"]["html5"])){
		$pageUrl["audio_med_res"] = $jsonStr["file_versions"]["html5"]["audio"]["med"]["url"];
	} 

	if(array_key_exists("url", $jsonStr["file_versions"]["iphone"])){
		$pageUrl["video_mobile_res"] = $jsonStr["file_versions"]["iphone"]["url"];
	} else if(array_key_exists("file", $jsonStr)){
		$pageUrl["video_mobile_res"] = $jsonStr["file"];
	}

	if(array_key_exists("title", $jsonStr))
		$pageUrl["title"] = $jsonStr["title"];

	return $pageUrl;

	#if(array_key_exists('video', $jsonStr["file_versions"]["html5"])){
	#	$pageUrl = $jsonStr["file_versions"]["html5"]["video"]["high"]["url"];
	#  	return $pageUrl;
	#} else if(array_key_exists('url', $jsonStr["file_versions"]["iphone"])){
	#	$pageUrl = $jsonStr["file_versions"]["iphone"]["url"];
	#  	return $pageUrl;
	#}

}

?>
