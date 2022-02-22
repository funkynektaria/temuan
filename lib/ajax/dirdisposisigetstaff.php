<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}

include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
include_once("../../simple/simplesess/simplesess.php");
$mysession = new simpleSESS($simplePAGE['skrxnt']);
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$subdit_id=($_GET['sid']);

//echo "ini";

$qGetStaff = "SELECT * FROM ".$simplePAGE['tableprefix']."user AS a, ".$simplePAGE['tableprefix']."usertosubdit AS b " .
				"WHERE " . 
				"(a.userID = b.user_id AND b.subdit_id = '$subdit_id') ";
			
//echo $qGetStaff;			
$fgetStaff = $database->simpleDB_queryinput($qGetStaff);

if($fgetStaff)
{
	$item = $fgetStaff;
	echo "<select class='form-control' id='user_id' name='user_id'>";
	echo "<option>--</option>";
	for($i=0;$i<count($item);$i++)
	{
		echo "<option value='".$item[$i]['userID']."'>".$item[$i]['userREALNAME']."</option>";
	}
	echo "</select>";
}
else
{
	echo "<option>--</option>";
}
?>