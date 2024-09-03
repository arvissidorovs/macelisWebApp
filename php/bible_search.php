
<?php

function trimparam($string){
$string = preg_replace('/\s(\S*)$/', '.$1', trim($string)); //trim end for sanitization.
return $string;
}


/**/
if (isset($_GET['tr']) && isset($_GET['s'])) {
  $tr = trimparam($_GET['tr']);
  $s = trimparam($_GET['s']);
	
  $tr = substr($tr, 0, 4);	//max 4 char
  $s = substr($s, 0, 300);	//max 2 char
	
/**/
//	{


	$servername = "localhost:3306";
	$username = "centradraudze";
	$password = "LcDmirT8!";
	$dbname = "maceklis_DB";

	$default_text = "John 3:16";
	$default_version = "t_kjv";




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");		
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$v_arr = array();	
//0 pans vieta virsrakstam	
array_push($v_arr, array('v' => 0, 't' => ''));	
	
$s = str_replace(" ", "%", $s);	
$s = str_replace(".", "%", $s);		
//echo $s;	

$s_arr = explode("%",$s);

$len = count($s_arr);	
$where = '';	
$where = "t_bez like concat('%',str_bez('$s_arr[0]'),'%')";	
	for ($i = 1; $i < $len; $i++) {
 	 $where = $where." and t_bez like concat('%',str_bez('$s_arr[$i]'),'%')";
		//echo "The number is: $x <br>";
	}
	
//$sql = "SELECT * FROM `t_".$tr."` where $where order by id;";	
$sql = "SELECT b.id, concat(n.abbreviation,' ',b.c,':', b.v) as title, b.t, b.b, b.c, b.v  FROM t_lv65 b left join book_info_lv n on b.b = n.order
where $where order by id;";	

//////////////////////////////////////////////////////////////////////////////////////
$v_arr = array();	
//$sql = "SELECT id, title, html FROM bible_comments order by id desc;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) { 
	  $t = $row["t"];
	  $t = mb_convert_encoding( $t, 'Windows-1252', 'UTF-8' );	
	  //echo $row["title"];
	  //echo $z;
	  array_push($v_arr, array('id' => $row["id"], 'title' => $row["title"], 't' => $t, 'b' =>  $row["b"], 'c' =>  $row["c"], 'v' =>  $row["v"]));
	  
  }		
$arr = array('rez' => 1, 'comemnts' => $v_arr); 	
echo json_encode($arr);

} else {
  //echo "0 results";
echo json_encode(array('rez' => 0));	
}	
//////////////////////////////////////////////////////////////////////////////////////	
$conn->close();
	
}
else 
{echo 'nav norādīti parametri';}	
?>


