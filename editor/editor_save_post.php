<?php
session_start();
date_default_timezone_set("Europe/Riga");
//ini_set('display_errors',1); error_reporting(E_ALL);
$u_editor_id = -1;
include('logedin.php');

if(logedin() > 0){
//header('Content-Type: application/json; charset=utf-8');

$is_ok = 0;
$rez_error = '';	

	$servername = "localhost:3306";
	$username = "centradraudze";
	$password = "LcDmirT8!";
	$dbname = "maceklis_DB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
$rez_error = $conn->connect_error;
}
//else {echo 'con: ok<br>';}

$in_json = json_decode(file_get_contents('php://input'), true);
//echo 'id='.$in_json['id'];
//echo 'word='.$in_json['word'];
//echo 'html='.$in_json['html'];


$id = strval($in_json['id']);
$last_id = $id;
$word = $in_json['word'];
$variations = $in_json['variations'];	
$html = addslashes($in_json['html']);
//echo 'megina';
if ($id>= 0 && strlen($word) >3 && strlen($variations) >3 && strlen($html) >3){

//echo $id; 
if ($id>0) { // update
//echo 'update';
$sql = "UPDATE dictionary SET 
word='$word',
variations='$variations',
html= '$html'
WHERE id = $id ";


if ($conn->query($sql) === TRUE) {
//$last_id = mysqli_insert_id($conn);
  //echo "Record updated successfully";
	$is_ok = 2;
} else {
	$is_ok = -1;
	$rez_error = $conn->error;
  //echo "Error: " . $sql . "<br>" . $conn->error;
}
}
else //insert
{
$sql = "INSERT INTO dictionary(word, variations, html) 
VALUES ('$word','$variations','$html')";


if ($conn->query($sql) === TRUE) {
$last_id = mysqli_insert_id($conn);
  //echo "New record created successfully".$last_id;
$is_ok = 1;
} else {
$is_ok = -1;
$rez_error = $conn->error;	
  //echo "Error: " . $sql . "<br>" . $conn->error;
}

}

}
 

$rezarr = array();
$rezarr["id"]    = $last_id;
$rezarr["rez"]    = $is_ok;
$rezarr["error"]   = $rez_error;

$json = json_encode($rezarr, true); // convert array to JSON string
echo $json; // return JSON data
}
else
{echo json_encode(array('rez' => -1000));	}	

?>