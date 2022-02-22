<?php
/*
// administration/body.php, v 0.1 
* body interface for simpledrome administration from
* SimpleDrome main package 
* SimpleDrome is Free Software
* Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*/

defined('CHECK_PAGE_ADMIN_') or die("You do not allowed to enter this page");
//echo $adminSimple->bodyShow;
if($adminSimple->bodyShow==1)
{
	if(isset($_GET['mode']))
	{
		$act_rep = preg_replace("/^com_/" , "" , $_GET['mode'] );
		//echo "components/" . $_GET['mode'] . "/" . $act_rep . ".php";
		if( file_exists( "components/" . $_GET['mode'] . "/" . $act_rep . ".php" ) )
		{
			include( "components/" . $_GET['mode'] . "/" . $act_rep . ".php" );
		}
		else
		{
			echo "wrong code to display";
		}
	}
	else
	{
		echo "wrong calling code";
	}
}
else
{
	include_once( "components/com_welcome/welcome.php" );
}
?>