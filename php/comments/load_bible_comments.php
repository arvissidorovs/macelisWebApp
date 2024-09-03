<?php
date_default_timezone_set("Europe/Riga");
ini_set('display_errors',1); error_reporting(E_ALL);


function remove_tags($str){
//$str = preg_replace('/font-size:\s*\d+px;/', 'font-size: 16px;', $str);
$str = str_replace("&nbsp;","",  $str);
//$str = preg_replace('/font-family\s*:\s*([^;]+);/', 'font-family: "Times New Roman";', $str);
//$str = str_replace("font-family","font-family-replaced", $str);
$str = str_replace("face=","face-replaced", $str);	
$str = str_replace("MsoNoSpacing","MsoNoSpacing_replaced", $str);
$str = preg_replace('/background-color:\s*rgb\(\d+,\s*\d+,\s*\d+\);/', '', $str);

	
//$str = str_replace("font-size","font-size-replaced", $str);	
	
//$str = strip_tags($str, '<p><a>');
//$str = strip_tags($str, '<b><p><i><span>');	
return $str;
}


function trimparam($string){
$string = preg_replace('/\s(\S*)$/', '.$1', trim($string)); //trim end for sanitization.
return $string;
}

/**/
if (isset($_GET['ofset']) && isset($_GET['b'])) {
  $ofset = trimparam($_GET['ofset']);
  $b = trimparam($_GET['b']);
	
  $ofset = substr($ofset, 0, 5);	//max 4 char
  $b = substr($b, 0, 5);	//max 4 char	

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
//$sql = "SELECT id, title, html FROM bible_comments where id = ".$id.";";

if ($b == 0){	
$sql = "SELECT id, title, html FROM bible_comments order by id desc;";	
}
else
{
$sql = "SELECT id, title, html FROM bible_comments where b='$b' order by b,c,v;";
}
	$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) { 
	  array_push($v_arr, array('id' => $row["id"], 'title' => $row["title"], 'html' => remove_tags($row["html"])));
	  
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

?>


