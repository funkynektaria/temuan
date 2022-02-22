<?php 

//echo "ada";
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//print_r($_POST);

//echo "ini terpanggil";
$absen_id = $_POST['aid'];

//echo $kode_propinsi;

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$queryAbsenRemove = "UPDATE ".$simplePAGE['tableprefix']."absen AS a " .
				"SET remove = '1' " .
				"WHERE absen_id = '$absen_id'";
							
//echo $queryKabKota;					
							
$fAbsenRemove = $database->simpleDB_queryinput($queryAbsenRemove);

if($fAbsenRemove)
{
	echo "Dihapus";
}
else
{
	echo "Gagal dihapus";
}
?>
