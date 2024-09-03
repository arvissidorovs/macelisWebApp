<?php
session_start();
date_default_timezone_set("Europe/Riga");
//ini_set('display_errors',1); error_reporting(E_ALL);

include('../editor/logedin.php');
$a = 0;
if(logedin() > 0){
$a = 1;
}

$arr = array('a' => $a); 	
echo json_encode($arr);

?>
