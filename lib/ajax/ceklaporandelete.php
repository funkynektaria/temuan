<?php 

//echo "ada";
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}

define( "CHECK_PAGE_ADMIN_", 1 );
define( "CHECK_PAGE_", 1 );

//print_r($_POST);
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
include_once("../../simple/simplesess/simplesess.php");
include_once("../../common.php");

//echo "ini terpanggil";
$user_id = $_SESSION['id'];
$laporan_id = $_POST['lid'];

echo $laporan_id;
echo "<br />";
echo $user_id;

//echo $kode_propinsi;



$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

//$queryAbsenRemove = "UPDATE ".$simplePAGE['tableprefix']."absen AS a " .
//				"SET remove = '1' " .
//				"WHERE absen_id = '$absen_id'";
							
//echo $queryKabKota;					
							
//$fAbsenRemove = $database->simpleDB_queryinput($queryAbsenRemove);

if($fAbsenRemove)
{
	echo "Dihapus";
}
else
{
	echo "Gagal dihapus";
}
?>
