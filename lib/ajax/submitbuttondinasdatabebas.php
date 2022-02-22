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

$responden=($_GET['responden']);
$kode_kab_kota =($_GET['kode_kab_kota']);
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

//echo $queryCheck;

$fetchdbCheck = $database->simpleDB_queryinput($queryCheck);
							
//echo $queryKabKota;		

if(count($fetchdbCheck) > 0)
{
?>
								<div class="row" style="margin-bottom:20px;">
                  <div class="col-sm-12 text-center"><span style="font-size:1.2em; color:red; font-weight:700;">Kabupaten, Responden, dan Nomor Telpon yang dipilih telah di input</span></div>
                </div>
<?php
}
else
{
?>
						<div class="row">
							<div class="col-sm-12 text-center">
								<button name="p" class="btn btn-info">Lanjutkan</button>
							</div>
						</div>
<?php
}
