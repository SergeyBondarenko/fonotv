<?php
$mongo = new MongoClient();
$db = $mongo->fonotv;
$collection = $db->hyperlinks;

$docs = $collection->find();

//print_r($docs);
foreach($docs as $doc){
	echo $doc["_id"] . $doc["file"] . "\n";
}

echo "<html><body>";

foreach($docs as $doc){
	echo "<div><video width='320' height='240' preload='auto' controls autoplay muted ><source src=".$doc['file']."></video></div>";
}

echo "</html></body>";


?>
