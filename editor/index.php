<?PHP
session_start();
date_default_timezone_set("Europe/Riga");
//ini_set('display_errors',1); error_reporting(E_ALL);
$u_editor_id = -1;
include('logedin.php');
$load_comment_id = 0;
if(isset($_GET['id'])){
	$load_comment_id = $_GET['id'];
	}

	
if(logedin() > 0){
		$sablons = 'editor.html';
    	$fileopen = fopen($sablons, "r");
    	$page = fread($fileopen, filesize($sablons));
		$page = str_replace('var load_comment_id = 0;', 'var load_comment_id = '.$load_comment_id.';', $page);
    	fclose($fileopen);
			echo $page;
	}
	else {
		$_SESSION['temp_editor_load_comment_id'] = $load_comment_id;
		header('Location: login.php');
	}
	
?>