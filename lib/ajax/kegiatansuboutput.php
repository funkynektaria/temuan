<?php 

//echo "ada";
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//echo "ini terpanggil";
$kode_propinsi = $_GET['kode_propinsi'];

//echo $kode_propinsi;

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$queryKabKota = "SELECT * FROM ".$simplePAGE['tableprefix']."core_kabupaten_kota AS a ".
				" WHERE kode_propinsi = '$kode_propinsi' ORDER BY kode_kab_kota ";
							
//echo $queryKabKota;					
							
$fetchdbKabKota = $database->simpleDB_queryinput($queryKabKota);
?>
		<div class="row">
			<div class="col-sm-12 mt-20">
				Kabupaten / Kota
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
					<select name="kode_kab_kota" class="form-control" id="kode_kab_kota" onchange="getKabKotaData(this.value)">
						<option value="">--Kabupaten Kota--</option>
<?php

	for($iKab = 0; $iKab<count($fetchdbKabKota); $iKab++)
	{
		echo "<option value=\"".$fetchdbKabKota[$iKab]['kode_kab_kota']."\">".$fetchdbKabKota[$iKab]['kabupaten_kota']."</option>\n";
	}
?>
					</select>
			</div>
		</div>
