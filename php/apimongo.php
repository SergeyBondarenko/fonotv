<?php
$mongo = new MongoClient();
$db = $mongo->fonotv;
$collection = $db->hyperlinks;

$docs = $collection->find();

//print_r($docs);

$docs_array = array();

foreach($docs as $doc){
	$docs_array[] = array("file" => $doc["file"]);
	//$docs_array[] = array("orig_page" => $doc["orig_page"]);
	//$docs_array[] = array("title" => $doc["title"]);
	//$docs_array["source"] = $doc["source"];
	//$docs_array["orig_page"] = $doc["orig_page"];
	//$docs_array["likes"] = $doc["likes"];
	//$docs_array["file"] = $doc["file"];
	//$docs_array["video_mobile_res"] = $doc["video_mobile_res"];
  //$docs_array["video_high_res_muted"] = $doc["video_high_res_muted"];
  //$docs_array["audio_high_res"] = $doc["audio_high_res"];
  //$docs_array["video_med_res_muted"] = $doc["video_med_res_muted"];
  //$docs_array["audio_med_res"] = $doc["audio_med_res"];
}

echo json_encode($docs_array);
  
?>
