<?PHP
	function LogedIn()
	{
	// return 19;
		if(isset($_SESSION['u_editor_id']) && $_SESSION['u_editor_id']>0)
		{
			if(isset($_SESSION['u_editor_stamp']) && $_SESSION['u_editor_stamp']+40000>time())
			{
			$_SESSION['u_editor_stamp'] = time();
			return $_SESSION['u_editor_id'];
			}
			else
			{
			$_SESSION['u_editor_id'] = -1;
			//header('Location: login.php');
			return 0;
			}
		}
		else
		{
			//header('Location: login.php');
			return 0;
		}
	}
?>

