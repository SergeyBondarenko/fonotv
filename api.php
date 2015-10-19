<?php

include 'php/functions.php';

$pageUrl = $_POST['url'];
$dbFile = 'json/coubs.json';
//$testFile = 'json/test.json';

$html = remote_get_contents($pageUrl);

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
} else if(array_key_exists('url', $jsonStr["file_versions"]["iphone"])){
	$pageUrl = $jsonStr["file_versions"]["iphone"]["url"];
}

if(file_exists($dbFile)){
	$videoJson = file_get_contents($dbFile, LOCK_EX);
	$videoArray = json_decode($videoJson, true);
	$newEid = count($videoArray);
} else {
	$newEid = 0;
} 

$videoArray[$newEid]["file"] = $pageUrl;

file_put_contents($dbFile, json_encode($videoArray), LOCK_EX);
//file_put_contents($dbFile, $pageUrl.PHP_EOL, FILE_APPEND | LOCK_EX);

?>
