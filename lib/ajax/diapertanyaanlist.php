<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
$instrumen_sub_id=($_GET['isid']);
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

//echo "ini";

$queryCheck = "SELECT * FROM ".$simplePAGE['tableprefix']."pertanyaan AS a " .
						"WHERE instrumen_sub_id = '$instrumen_sub_id' AND " .
						//"( pertanyaan_type = '1' OR pertanyaan_type = '2' OR pertanyaan_type = '3' OR pertanyaan_type = '4' OR " . 
						//"pertanyaan_type = '5' OR pertanyaan_type = '6' OR pertanyaan_type = '11') ORDER BY pertanyaan_id";
						"(pertanyaan_type = '3' OR pertanyaan_type = '4' OR pertanyaan_type = '7' OR pertanyaan_type = '10') ORDER BY pertanyaan_id";
						
//echo $queryCheck;

$fetchdbCheck = $database->simpleDB_queryinput($queryCheck);

if(count($fetchdbCheck) == 0)
{
?>
											<label class="form-control-label">Pilih Pertanyaan</label>
	                  	<select name="ptra_pertanyaan_id" id="ptra_pertanyaan_id" class="form-control">
	                  		<option>--Pertanyaan--</option>
	                  	</select>
<?php
}
else
{
?>
											<label class="form-control-label">Pilih Pertanyaan</label>
	                  	<select name="ptra_pertanyaan_id" id="ptra_pertanyaan_id" class="form-control" onchange="getDiagramData(this.value, ptra_kode_propinsi.value, ptra_kode_kab_kota.value)">
	                  		<option>--Pertanyaan--</option>
	                  		<?php
	                  			for($i=0;$i<count($fetchdbCheck);$i++)
	                  			{
														echo '<option value="'.$fetchdbCheck[$i]['pertanyaan_id'].'">'.str_replace("::comma::",",",$fetchdbCheck[$i]['pertanyaan_isi']).'</option>';
													}
	                  		?>
	                  	</select>
<?php

}
?>