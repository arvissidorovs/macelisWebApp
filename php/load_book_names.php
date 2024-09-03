
<?php


/**/
if (isset($_GET['tr'])) {
  $tr = $_GET['tr'];	

  $tr= substr($tr, 0, 2);	//max 4 char
$table_name = 'book_info';
if ($tr == 'lv') {$table_name = 'book_info_lv';}
	
	$servername = "localhost:3306";
	$username = "centradraudze";
	$password = "LcDmirT8!";
	$dbname = "maceklis_DB";




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");	

//mysql_set_charset("utf8", $conn);	
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$arr = array();	
	
$sql = "SELECT `order` id, title_short, title_full, abbreviation, str_bez(abbreviation) as abb, chapters, otnt  FROM $table_name;";
		
$result = $conn->query($sql);

	
$v_last=0;
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {     
	  array_push($arr, array('i' => $row["id"], 
							   's' => $row["title_short"],
							   'f' => $row["title_full"],
							   'a' => $row["abbreviation"],
							   'abb' => str_replace(" ", "", $row["abb"]),
							   'c' => $row["chapters"],
							   'on' => $row["otnt"],
							  
							  ));
	  
  }	
	
echo json_encode($arr);

} else {	
echo json_encode(array());	
}
$conn->close();
	
/**/	
}
else 
{echo 'nav norādīti parametri';}	
?>


