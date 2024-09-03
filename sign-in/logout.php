<?PHP
session_start();
date_default_timezone_set("Europe/Riga");

$_SESSION['u_editor_id'] = -1;
header('Location: login.php');

?>

