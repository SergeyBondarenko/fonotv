<?php

include 'functions.php';

$myParams = json_decode(file_get_contents('php://input'),true);
//print_r(count($myParams['coubText']));

if(!empty($myParams['coubText'])){
	$myCoubText = $myParams['coubText'];
} else {
	$myCoubText = 'rocket';
}

$myOrderBy = 'newest_popular';

$coubApiUrl = 'http://coub.com/api/v2/search?q='.urlencode($myCoubText).'&order_by='.$myOrderBy;
$coubSearchResp = remote_get_contents($coubApiUrl);

echo $coubSearchResp;

/*$fp = fopen('json/coubs.json', 'w');
fwrite($fp, $coubSearchResp);
fclose($fp);
*/
?>
