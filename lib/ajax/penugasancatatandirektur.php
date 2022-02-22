<?php
//echo "saya ada";
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
include_once("../../simple/simplesess/simplesess.php");
$mysession = new simpleSESS($simplePAGE['skrxnt']);
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

if(!isset($_SESSION['id']))
{
	exit();
}

//print_r($_FILES);

//print_r($_SESSION);

$penugasan_id = $_POST['pid'];
$catatan = $_POST['catatan'];

$datetimenow = date("Y-m-d H:i:s");
$user_id = $_SESSION['id'];

$query = "UPDATE " .
$simplePAGE['tableprefix'] . "laporan_penugasan " .
"SET 
catatan_direktur = '$catatan', 
catatan_datetime = '$datetimenow'
WHERE  
penugasan_id = '$penugasan_id'";
//echo $query;

$fetchdb = $database->simpleDB_queryinput($query);

if($fetchdb)
{
echo '<span class="text-success p-2">Catatan telah ditambahkan</span>';
}
if($fetchdb)
{
	$queryLog = "INSERT INTO ".$simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
							"VALUES " .
							"( 'record catatan direktur penugasan id =".$penugasan_id."', '".addslashes($query)."', '".date("Y-m-d H:i:s")."', '$user_id' )";
		
		//echo $query;
							
	$fetchdbLog = $database->simpleDB_queryinput($queryLog);
}



?>