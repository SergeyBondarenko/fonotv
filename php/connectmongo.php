<?php

$mongo = new MongoClient();
$db = $mongo->fonotv;
$collection = $db->hyperlinks;

if(isset($_GET["doc"])){
  //print_r($_GET["doc"]);
  $collection->remove(array('file' => $_GET["doc"]));  
}

if(isset($_GET["removeall"])){
  if($_GET["removeall"] == true){
    $docs = $collection->find();
    foreach($docs as $doc){
      $collection->remove(array('file' => $doc["file"]));  
    }
  }
}

$docs = $collection->find();

//print_r($docs);
//foreach($docs as $doc){
//	echo $doc["_id"] . $doc["file"] . "\n";
//}

echo "<html><body>";
echo "<h2><a href='connectmongo.php'>Reconnect</a></h2>";
echo "<h3><a href='connectmongo.php?removeall=true'>Dangerous!!! Remove all videos from DB</a></h3>"; 

foreach($docs as $doc){
	//echo "<div><video width='320' height='240' preload='auto' controls muted ><source src=".$doc['file']."></video></div>";
  echo "<a href='".$doc['file']."' target='_blank'>".$doc['file']."</a><br>";
  echo "<a href='connectmongo.php?doc=".$doc['file']."'>Remove video from DB.</a><br><br><br>";
}

echo "</html></body>";


?>
