<?php
echo '<html><body>';
echo '<h2>Insert links into DB</h2>';
echo '<form action='.$_SERVER['PHP_SELF'].' method="post"><textarea rows="8" cols="50" name="links_list"></textarea><br><input type="submit" value="Submit"></form>';

// Connect to DB and get a collection
$mongo = new MongoClient();
$db = $mongo->fonotv;
$collection = $db->hyperlinks;

// Remove one video at a time
if(isset($_GET['doc'])){
  $collection->remove(array('file' => $_GET['doc']));  
}

// Remove all videos
if(isset($_GET['removeall'])){
  if($_GET['removeall'] == true){
    $docs = $collection->find();
    foreach($docs as $doc){
      $collection->remove(array('file' => $doc['file']));  
    }
  }
	// Redirect back to the manager. It's for removing removeall=true from URI
	header('Location: http://www.fonotv.com/manage/index.php');
	exit;
}

// Display collection
$docs = $collection->find();
echo "<h3><a href='".$_SERVER['PHP_SELF']."?removeall=true'>Dangerous!!! Remove all videos from DB</a></h3>"; 

foreach($docs as $doc){
	echo "<div><video width='320' height='240' preload='none' controls><source src=".$doc['file']."></video></div>";
  echo "<a href='".$doc['file']."' target='_blank'>".$doc['file']."</a><br>";
  echo "<a href='toughillegalalligator.php?doc=".$doc['file']."'>Remove video from DB.</a><br><br><br>";
}

// POST links to fonotv.com api
function post_links_to_server($server, $link){
	$link = urlencode($link);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $server);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'url='.$link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close($ch);
}

$fonotvServer = 'http://www.fonotv.com/api.php';

$text = trim($_POST['links_list']);
$textAr = explode("\n", $text);
$textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind

foreach ($textAr as $line) {
	post_links_to_server($fonotvServer, $line);
	//echo $line.'<br>';
} 
echo '</body></html>';

?>
