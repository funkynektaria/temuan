<?php
//echo "saya ada";
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
include_once("../../simple/simplesess/simplesess.php");
$mysession = new simpleSESS($simplePAGE['skrxnt']);
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

if (!isset($_SESSION['id'])) {
	exit();
}

if ( empty($_FILES["file"]["tmp_name"]) ) {
	echo "Silakan unggah berkas pada form input di atas";
	exit();
}

//print_r($_FILES);

//print_r($_SESSION);

//$kode_kab_kota = $_SESSION['kode_kab_kota'];
$user_id = $_SESSION['id'];

$pic_kegiatan_id = $_POST['tinid'];
$target_dir = $simplePAGE['uploaddir'];
$datefilename = date("YmdHis");
$fileName = basename($_FILES["file"]["name"]);
$expFiles = explode(".", $fileName);
$extFiles = end($expFiles);

$datetimenow = date("Y-m-d H:i:s");

$target_file = "../../" . $target_dir . "tinjut-" . $user_id . "-" . $pic_kegiatan_id .  "-" . $datefilename . "." . $extFiles;

$fileNameForDB = "tinjut-" . $user_id . "-" . $pic_kegiatan_id . "-" . $datefilename . "." . $extFiles;

$uploadOk = 1;

// Check file size
if ($_FILES["file"]["size"] > 20000000) {
	echo "File yang anda unggah memiliki ukuran yang terlalu besar.";
	$uploadOk = 0;
}


//echo $filetype;

//echo "<br />";
//echo strpos( $filetype, "pdf" );
//echo "<br />";


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "<br />";
	echo '<span style="color:#cc0000;">Berkas Anda gagal diunggah</span>';
} else {
	if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
		$query = "INSERT INTO " .
		$simplePAGE['tableprefix'] . "tinjutdokumen " .
		"(tinjutdokumen_loc,tinjutdokumen_datetime, user_id, tinjut_id) " .
		"VALUES " .
		"('$fileNameForDB', '$datetimenow', '".$user_id."', '".$pic_kegiatan_id."')";
		//echo $query;

		$fetchdb = $database->simpleDB_queryinput($query);

		$queryLog = "INSERT INTO ".$simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
		"VALUES " .
		"( 'upload tindak lanjut dokumen', '".addslashes($query)."', '".date("Y-m-d H:i:s")."', '$user_id' )";

		//echo $query;

		$fetchdbLog = $database->simpleDB_queryinput($queryLog);

		echo "<span class='text-primary'>berkas ". basename( $_FILES["file"]["name"]). " telah berhasil di unggah</span>";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}

?><?php

?>