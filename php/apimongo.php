<?php
$mongo = new MongoClient();
$db = $mongo->fonotv;
$collection = $db->hyperlinks;

$docs = $collection->find();

//print_r($docs);

$docs_array = array();

foreach($docs as $doc){
	$docs_array[] = array("source" => $doc["source"], 
												"orig_page" => $doc["orig_page"],
												"title" => $doc["title"],
												"likes" => $doc["likes"],
												"file" => $doc["file"],
												"video_mobile_res" => $doc["video_mobile_res"],
												"video_high_res_muted" => $doc["video_high_res_muted"],
												"audio_high_res" => $doc["audio_high_res"],
												"video_med_res_muted" => $doc["video_med_res_muted"],
												"audio_med_res" => $doc["audio_med_res"]);
}

echo json_encode($docs_array);
  
?>
