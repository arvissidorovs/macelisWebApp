<?PHP
session_start();
	date_default_timezone_set("Europe/Riga");
	ini_set('display_errors',1);
 error_reporting(E_ALL);
$u_editor_id = -1;

if (isset($_POST['user']) && isset($_POST['psw'])){
$epasts = $_POST['user'];
$i_password = $_POST['psw'];
$browser = $_SERVER['HTTP_USER_AGENT'];

		$input = array ('&', "'", '<', '>', '?' );
		$output = array ('&amp;', '&apos;' , '&lt;' , '&gt;', '&#63;');
		$epasts = str_replace(';', '&#59;', $epasts);
		$epasts = str_replace('"', '&quot;', $epasts);
		$epasts = str_replace($input, $output, $epasts);
		$epasts = chop($epasts);
		$password = bin2hex(md5($i_password, TRUE ));

		if ((strlen($epasts)<=100) and (strlen($password)==32) /*and (strlen($ID)<=5)*/)
		{
$ip=$_SERVER["REMOTE_ADDR"];
if (($epasts == 'renars@velokurjers.lv' && $i_password == 'LaiTop,22.') ) {$u_editor_id = 1; $u_editor='Renārs';}
else
if (($epasts == 'martins' && $i_password =='LaiTop1Mozus1:3')) {$u_editor_id = 2; $u_editor='Mārtiņš';}	
else
if (($epasts == 'arvis' && $i_password =='Pagaidu1.2#')) {$u_editor_id = 3; $u_editor='Arvis';}				
else
if (($epasts == 'ilmars' && $i_password =='IzskaidrojaLuk24:27')) {$u_editor_id = 4; $u_editor='ilmars';}	
			
//echo $u_editor_id;
		$datetime = time();
		$ip=$_SERVER["REMOTE_ADDR"];
		if($u_editor_id > 0)
		{
			$_SESSION['u_editor_id'] = $u_editor_id;
			$_SESSION['u_editor_stamp'] = time();
			$_SESSION['u_editor'] = $u_editor;
			$temp_editor_load_comment_id=0;
			if(isset($_SESSION['temp_editor_load_comment_id']) && $_SESSION['temp_editor_load_comment_id']>=0){
			$temp_editor_load_comment_id = $_SESSION['temp_editor_load_comment_id'];
			$_SESSION['temp_editor_load_comment_id']=-1;
			header('Location: /editor/?id='.$temp_editor_load_comment_id);
			}
			else
			if(isset($_SESSION['temp_editor_load_dictionary_id']) && $_SESSION['temp_editor_load_dictionary_id']>=0){
			$temp_editor_load_dictionary_id = $_SESSION['temp_editor_load_dictionary_id'];
			$_SESSION['temp_editor_load_dictionary_id']=-1;
			header('Location: /editor/dictionary.php?id='.$temp_editor_load_dictionary_id);	
			}	
			else
			header('Location: /editor/');
			
		}
		}
	}

if($u_editor_id <= 0){
	$sablons = 'login.html';
    $fileopen = fopen($sablons, "r");
    $page = fread($fileopen, filesize($sablons));
    fclose($fileopen);
		echo $page;
	}
?>

