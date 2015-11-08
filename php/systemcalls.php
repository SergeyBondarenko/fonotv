<?php


$myParams = json_decode(file_get_contents('php://input'),true);

$myCoubText = $myParams['coubDB'];

unlink("/home/sergibondarenko/sergi/files/webservers/wordcharge/fonotv/".$myCoubText);

?>
