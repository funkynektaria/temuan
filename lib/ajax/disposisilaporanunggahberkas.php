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

if( empty($_FILES["file"]["tmp_name"]) )
{
	echo "Silakan unggah berkas pada form input di atas";
	exit();
}

//print_r($_FILES);

//print_r($_SESSION);

$userID = $_SESSION['id'];

$disposisi_id = $_POST['did'];

$target_dir = $simplePAGE['uploaddir'];
$datefilename = date("YmdHis");
$fileName = basename($_FILES["file"]["name"]);
$expFiles = explode(".", $fileName);
$extFiles = end($expFiles);

$datetimenow = date("Y-m-d H:i:s");

$target_file = "../../" . $target_dir . $userID . "-" . $datefilename . "." . $extFiles;

$fileNameForDB = $userID . "-" . $datefilename . "." . $extFiles;

$uploadOk = 1;

// Check file size
if ($_FILES["file"]["size"] > 20000000) {
  echo "File yang anda unggah memiliki ukuran yang terlalu besar.";
  $uploadOk = 0;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$filetype = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "<br />";
	echo '<span style="color:#cc0000;">Berkas Anda gagal diunggah</span>';
} 
else 
{
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) 
  {
  	$query = "INSERT INTO " .
				$simplePAGE['tableprefix'] . "disposisi_laporan " .
				"(disposisi_id, disposisi_laporan_berkas,disposisi_laporan_datetime, staff_user_id) " .
				"VALUES " . 
				"('".$disposisi_id."','".$fileNameForDB."', '".$datetimenow."', '".$userID."' )";
		//echo $query;
		
		$fetchdb = $database->simpleDB_queryinput($query);
		
		$queryLog = "INSERT INTO ".$simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
							"VALUES " .
							"( 'upload file dis id =".$disposisi_id."', '".addslashes($query)."', '".date("Y-m-d H:i:s")."', '$userID' )";
		
		//echo $query;
							
		$fetchdbLog = $database->simpleDB_queryinput($queryLog);
		
    echo "<span class='text-primary'>berkas ". basename( $_FILES["file"]["name"]). " telah berhasil di unggah</span>";
  } 
  else 
  {
    echo "Sorry, there was an error uploading your file.";
  }
}

?>