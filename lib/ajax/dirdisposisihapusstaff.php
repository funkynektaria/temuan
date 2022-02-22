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

$disposisi_staff_id=$_POST['stid'];
$disposisi_id = $_POST['did'];


//echo "ini";

$qInputStaff = "DELETE FROM ".$simplePAGE['tableprefix']."disposisi_staff " .
				"WHERE " . 
				"disposisi_staff_id = ('$disposisi_staff_id') ";
			
//echo $qInputStaff;			

$fInputStaff = $database->simpleDB_queryinput($qInputStaff);

$qLog = "INSERT INTO ".$simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
						"VALUES " .
						"( 'Hapus Staff Disposisi dis id=".$disposisi_id."', '".addslashes($qInputStaff)."', '".date("Y-m-d H:i:s")."', '".$_SESSION['id']."' )";
	
//echo $query;
						
$fLog = $database->simpleDB_queryinput($qLog);

$qGetStaff = "SELECT * FROM ".$simplePAGE['tableprefix']."disposisi_staff  " .
				"WHERE  " . 
				"disposisi_id = '$disposisi_id' ";
			
//echo $qGetStaff;			
$fgetStaff = $database->simpleDB_queryinput($qGetStaff);

if($fgetStaff)
{
	$item = $fgetStaff;
	for($i=0;$i<count($item);$i++)
	{
		echo "<div class='row mt-1'>";
		echo "<div class='col-sm disposisi-staff-bg'>";
		echo $item[$i]['nama_staff'];
		echo "</div>";
		echo "<div class='col-sm-1'>";
		echo "<button class='btn btn-danger btn-sm' onclick=hapusStaff(".$item[$i]['disposisi_staff_id'].")>Hapus</button>";
		echo "</div>";
		echo "</div>";
	}
}
else
{
	
}
?>