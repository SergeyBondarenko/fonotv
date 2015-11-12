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

//Verify if url is from coub.com
  if(($my_host == "coub.com") && ($my_path_arr[1] == "view") && (sizeof($my_path_arr) == 3)){
  
    //Get HTML for coub.com
    $html = remote_get_contents($pageUrl);
    
    //Parse HTML and get url for coub video
    $pageUrl = get_coub_video_link($html, $pageUrl);
    
	  // Connect to DB
	  $mongo = new MongoClient();
	  $db = $mongo->fonotv;
	  $collection = $db->hyperlinks;
	  
	  // Save to DB
	  $document = array("file" => $pageUrl);
	  $collection->insert($document);
  }

}
?>
