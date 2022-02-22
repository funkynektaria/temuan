<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
$kode_propinsi=($_GET['kode_propinsi']);
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

//echo "ini";

$queryCheck = "SELECT * FROM ".$simplePAGE['tableprefix']."core_kabupaten_kota AS a " .
						"WHERE kode_propinsi = '$kode_propinsi'";

//echo $queryCheck;

$fetchdbCheck = $database->simpleDB_queryinput($queryCheck);

if(count($fetchdbCheck) == 0)
{
?>
											<label class="form-control-label">Pilih Kabupaten</label>
	                  	<select name="kode_kab_kota" id="kode_kab_kota" class="form-control">
	                  		<option value="--Semua--">--Semua--</option>
	                  	</select>
<?php
}
else
{
?>
											<label class="form-control-label">Pilih Kabupaten</label>
	                  	<select name="kode_kab_kota" id="kode_kab_kota" class="form-control" onchange="getJawabanToUserList(instrumen_sub_id.value, kode_propinsi.value, this.value)">
	                  		<option value="--Semua--">--Semua--</option>
	                  		<?php
	                  			for($i=0;$i<count($fetchdbCheck);$i++)
	                  			{
														echo '<option value="'.$fetchdbCheck[$i]['kode_kab_kota'].'">'.$fetchdbCheck[$i]['kabupaten_kota'].'</option>';
													}
	                  		?>
	                  	</select>
<?php

}
?>