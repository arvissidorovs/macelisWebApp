<?php
session_start();
date_default_timezone_set("Europe/Riga");
//ini_set('display_errors',1); error_reporting(E_ALL);
$u_editor_id = -1;
include('logedin.php');


function trimparam($string){
$string = preg_replace('/\s(\S*)$/', '.$1', trim($string)); //trim end for sanitization.
return $string;
}

if(logedin() > 0){
/**/
if (isset($_GET['id'])) {
  $id = trimparam($_GET['id']);
	
  $id = substr($id, 0, 5);	//max 4 char

	$servername = "localhost:3306";
	$username = "centradraudze";
	$password = "LcDmirT8!";
	$dbname = "maceklis_DB";

	$default_text = "John 3:16";
	$default_version = "t_kjv";




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$v_arr = array();	
//0 pans vieta virsrakstam	
//array_push($v_arr, array('v' => 0, 't' => ''));	
$sql = "SELECT id, word, variations, html FROM dictionary where id = ".$id.";";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) { 
	  array_push($v_arr, array('id' => $row["id"], 'word' => $row["word"], 'variations' => $row["variations"], 'html' => $row["html"]));
	  
  }		
$arr = array('rez' => 1, 'comemnts' => $v_arr); 	
echo json_encode($arr);

} else {
  //echo "0 results";
echo json_encode(array('rez' => 0));	
}
$conn->close();
	
}
else 
{echo 'nav norādīti parametri';}	
}	
else
{echo json_encode(array('rez' => -1000));	}
?>


