<?php

include 'php/functions.php';

$pageUrl = $_POST['url'];
//$dbFile = 'json/coubs.json';

//Verify URL
$pageUrl = filter_var($pageUrl, FILTER_SANITIZE_URL);

if (!filter_var($pageUrl, FILTER_VALIDATE_URL) === false) {

  $my_host = parse_url($pageUrl, PHP_URL_HOST);
  $my_path = parse_url($pageUrl, PHP_URL_PATH);
  $my_path_arr = explode("/", $my_path);

  if(($my_host == "coub.com") && ($my_path_arr[1] == "view") && (sizeof($my_path_arr) == 3)){
  
    //Get HTML for coub.com
    $html = remote_get_contents($pageUrl);
    
    //Parse HTML and get url for coub video
    $pageUrl = get_coub_video_link($html, $pageUrl);
    
	  // Save to db
	  $mongo = new MongoClient();
	  $db = $mongo->fonotv;
	  $collection = $db->hyperlinks;
	  
	  $document = array("file" => $pageUrl);
	  $collection->insert($document);
  }

  //if(file_exists($dbFile)){
  //	$videoJson = file_get_contents($dbFile, LOCK_EX);
  //	$videoArray = json_decode($videoJson, true);
  //	$newEid = count($videoArray);
  //} else {
  //	$newEid = 0;
  //} 
  //
  //$videoArray[$newEid]["file"] = $pageUrl;
  //
  //file_put_contents($dbFile, json_encode($videoArray), LOCK_EX);
  ////file_put_contents($dbFile, $pageUrl.PHP_EOL, FILE_APPEND | LOCK_EX);
}
?>
