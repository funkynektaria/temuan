<?php
function simple_admin_read_file($type)
{	global $simplePAGE;
	$mode_rep = preg_replace("/^(com_)/" , "" , $_GET['mode'] );
	if($type == "html")
	{
		$ext = "html.php";
	}
	if($type == "class")
	{
		$ext = "class.php";
	}
	$path = "components/" . $_GET['mode'] . "/" . $mode_rep . "." . $ext;
	return $path;
}
?>