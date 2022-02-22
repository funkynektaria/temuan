<?php 

//echo "ada";
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//echo "ini terpanggil";

//echo $kode_propinsi;

$responden=($_GET['res']);
$kode_kab_kota =($_GET['kab']);
$telp=($_GET['telp']);
$instrumen_id = $_GET['pid'];

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$queryCheck = "SELECT kode_kab_kota FROM ".$simplePAGE['tableprefix']."jawabantouser AS a " .
						"WHERE kode_kab_kota = '$kode_kab_kota' AND " . 
						"responden = '$responden' AND " .
						"telp_responden = '$telp' AND " .
						"instrumen_sub_id = '$instrumen_id'";

echo $queryCheck;

$fetchdbCheck = $database->simpleDB_queryinput($queryCheck);
							
//echo $queryKabKota;					
?>
						<div class="row">
							<div class="col-sm-12 text-center">
								<button name="p" class="btn btn-info">Lanjutkan</button>
							</div>
						</div>
