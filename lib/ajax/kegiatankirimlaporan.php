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

$kegiatan_id = $_POST['kid'];
$output = $_POST['output'];
$topik = $_POST['topik'];
$narasumber = $_POST['narasumber'];
$peserta_kegiatan = $_POST['peserta_kegiatan'];
$skenario = $_POST['skenario'];
$rangkuman = $_POST['rangkuman'];

$datetimenow = date("Y-m-d H:i:s");
$user_id = $_SESSION['id'];

$qCheck = "SELECT kegiatan_id FROM " . $simplePAGE['tableprefix'] . "laporan_kegiatan_staff " .
		"WHERE kegiatan_id = $kegiatan_id";

$fCheck = $database->simpleDB_queryinput($qCheck);

if (is_array($fCheck) || $fCheck instanceof Countable) {
   $query = "UPDATE " .
		$simplePAGE['tableprefix'] . "laporan_kegiatan_staff " .
		"SET 
		output = '$output', 
		topik = '$topik', 
		narasumber = '$narasumber', 
		peserta_kegiatan = '$peserta_kegiatan', 
		skenario = '$skenario', 
		rangkuman = '$rangkuman',
		updated = '$datetimenow'
		WHERE  
		user_id = '$user_id' AND kegiatan_id = '$kegiatan_id'";
//echo $query;

	$fetchdb = $database->simpleDB_queryinput($query);

	if($fetchdb)
	{
		echo '<span class="text-primary p-2">Data Sukses diubah</span>';
	}
}
else
{
	$query = "INSERT INTO " .
		$simplePAGE['tableprefix'] . "laporan_kegiatan_staff " .
		"(output, topik, narasumber, peserta_kegiatan, skenario, rangkuman, user_id, kegiatan_id, created) " . 
		"VALUES ".
		"('$output', '$topik', '$narasumber', '$peserta_kegiatan', '$skenario', '$rangkuman', '$user_id', '$kegiatan_id', '$datetimenow') ";
//echo $query;

	$fetchdb = $database->simpleDB_queryinput($query);

	if($fetchdb)
	{
		echo '<span class="text-primary p-2">Data Sukses ditambahkan</span>';
	}
	else
	{
		echo '<span class="text-danger p-2">Data Gagal ditambahkan</span>';
	}
}

if($fetchdb)
{
	$queryLog = "INSERT INTO ".$simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
							"VALUES " .
							"( 'record laporan kegiatan id =".$kegiatan_id."', '".addslashes($query)."', '".date("Y-m-d H:i:s")."', '$user_id' )";
		
		//echo $query;
							
	$fetchdbLog = $database->simpleDB_queryinput($queryLog);
}



?>