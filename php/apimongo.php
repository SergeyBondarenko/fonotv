<?php
$mongo = new MongoClient();
$db = $mongo->fonotv;
$collection = $db->hyperlinks;

$docs = $collection->find();

//print_r($docs);

$docs_array = array();

foreach($docs as $doc){
	$docs_array[] = array("file" => $doc["file"]);
}

echo json_encode($docs_array);
  
?>
