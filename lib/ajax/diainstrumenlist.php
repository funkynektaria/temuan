<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
$instrumen_id=($_GET['monid']);
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

//echo "ini";

$queryCheck = "SELECT * FROM ".$simplePAGE['tableprefix']."instrumen_sub AS a " .
						"WHERE instrumen_id = '$instrumen_id'";

//echo $queryCheck;

$fetchdbCheck = $database->simpleDB_queryinput($queryCheck);

if(count($fetchdbCheck) == 0)
{
?>
											<label class="form-control-label">Pilih Instrumen</label>
	                  	<select name="ptra_instrumen_sub_id" class="form-control">
	                  		<option>--Instrumen--</option>
	                  	</select>
<?php
}
else
{
?>
											<label class="form-control-label">Pilih Instrumen</label>
	                  	<select name="ptra_instrumen_sub_id" class="form-control" onchange="getPertanyaanList(this.value)">
	                  		<option>--Instrumen--</option>
	                  		<?php
	                  			for($i=0;$i<count($fetchdbCheck);$i++)
	                  			{
														echo '<option value="'.$fetchdbCheck[$i]['instrumen_sub_id'].'">'.$fetchdbCheck[$i]['instrumen_sub_name'].'</option>';
													}
	                  		?>
	                  	</select>
<?php

}
?>