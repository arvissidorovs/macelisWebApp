<?php
date_default_timezone_set("Europe/Riga");
ini_set('display_errors',1); error_reporting(E_ALL);



function trimparam($string){
$string = preg_replace('/\s(\S*)$/', '.$1', trim($string)); //trim end for sanitization.
return $string;
}

/**/
if (isset($_GET['ofset'])) {
  $ofset = trimparam($_GET['ofset']);
	
  $ofset = substr($ofset, 0, 5);	//max 4 char

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
$sql = "SELECT id, word, variations, html FROM dictionary order by word;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) { 
	  array_push($v_arr, array('id' => $row["id"], 'word' => $row["word"], 'variations' => $row["variations"], 'html' => $row["html"]));
	  
  }		
$arr = array('rez' => 1, 'dictionary' => $v_arr); 	
echo json_encode($arr);

} else {
  //echo "0 results";
echo json_encode(array('rez' => 0));	
}
$conn->close();
	
}
else 
{echo 'nav norādīti parametri';}	

?>


