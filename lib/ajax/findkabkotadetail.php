<?php 

//echo "ada lagi";
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
$kode_kab_kota=($_GET['kode_kab_kota']);
$instrumen_id = $_GET['pid'];
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );
//$link = mysql_connect($simplePAGE['host'], $simplePAGE['username'], $simplePAGE['password']); //changet the configuration in required
//if (!$link) {
//    die('Could not connect: ' . mysql_error());
//}



$queryCheck = "SELECT kode_kab_kota FROM ".$simplePAGE['tableprefix']."jawabantouser AS a " .
						"WHERE kode_kab_kota = '$kode_kab_kota' AND instrumen_sub_id = '$instrumen_id'";

//echo $queryCheck;

$fetchdbCheck = $database->simpleDB_queryinput($queryCheck);

//echo $fetchdbCheck[0]['kode_kab_kota'];

if(count($fetchdbCheck) > 0)
{
?>
								<div class="row" style="margin-bottom:20px;">
                  <div class="col-sm-12 text-center"><span style="font-size:1.2em; color:red; font-weight:700;">Kabupaten yang dipilih telah di input</span></div>
                </div>
<?php
}
else
{
	if($kode_kab_kota == '')
	{
		
	}
	elseif(empty($fetchdbCheck[0]['kode_kab_kota']))
	{
?>
		<div class="row">
			<div class="col-sm-12 text-center"><button class="btn btn-info">Pilih</button></div>
		</div>
<?php
	}
}
?>