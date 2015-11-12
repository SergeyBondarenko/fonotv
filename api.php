<?php

include 'php/functions.php';

$COUB = "coub.com";
$pageUrl = $_POST['url'];
//$dbFile = 'json/coubs.json';

//Verify URL
$pageUrl = filter_var($pageUrl, FILTER_SANITIZE_URL);

if (!filter_var($pageUrl, FILTER_VALIDATE_URL) === false) {

  $my_host = parse_url($pageUrl, PHP_URL_HOST);
  $my_path = parse_url($pageUrl, PHP_URL_PATH);
  $my_path_arr = explode("/", $my_path);

//Verify if url is from coub.com
  if(($my_host == $COUB) && ($my_path_arr[1] == "view") && (sizeof($my_path_arr) == 3)){
  
    //Get HTML for coub.com
    $html = remote_get_contents($pageUrl);
    
    //Parse HTML and get array of urls for coub video and audio
	//with diff resolutions
	$orig_pageUrl = $pageUrl;
    $pageUrl = get_coub_video_link($html, $pageUrl);
    
	// Connect to DB
	$mongo = new MongoClient();
	$db = $mongo->fonotv;
	$collection = $db->hyperlinks;
	
	// Construct a DB document
	$document = array("source" => $COUB, "orig_page" => $orig_pageUrl, "likes" => 0);
	$document["title"] = $pageUrl["title"]; 
	$document["file"] = $pageUrl["video_mobile_res"]; 
	$document["video_mobile_res"] = $pageUrl["video_mobile_res"]; 
	$document["video_high_res_muted"] = $pageUrl["video_high_res_muted"]; 
	$document["audio_high_res"] = $pageUrl["audio_high_res"]; 
	$document["video_med_res_muted"] = $pageUrl["video_med_res_muted"]; 
	$document["audio_med_res"] = $pageUrl["audio_med_res"]; 
	//$document = array("source" => $COUB, "file" => $pageUrl, "orig_page" => $orig_pageUrl, "likes" => 0);
	
	// Save to DB
	$collection->insert($document);
  }

}
?>
