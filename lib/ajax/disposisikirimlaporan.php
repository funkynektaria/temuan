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

$disposisi_id = $_POST['did'];
$content = $_POST['con'];
$datetimenow = date("Y-m-d H:i:s");
$user_id = $_SESSION['id'];

$query = "INSERT INTO " .
		$simplePAGE['tableprefix'] . "disposisi_laporan " .
		"(disposisi_id, disposisi_laporan_content, disposisi_laporan_datetime, staff_user_id) " . 
		"VALUES ".
		"('$disposisi_id', '$content',  '$datetimenow', '$user_id') ";
//echo $query;

$fetchdb = $database->simpleDB_queryinput($query);

$queryLog = "INSERT INTO ".$simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
							"VALUES " .
							"( 'record laporan dis id =".$disposisi_id."', '".addslashes($query)."', '".date("Y-m-d H:i:s")."', '$user_id' )";
		
		//echo $query;
							
$fetchdbLog = $database->simpleDB_queryinput($queryLog);


?>