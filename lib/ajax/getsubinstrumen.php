<?php 

if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//echo "ada";
$instrumen_id=($_GET['insid']);

include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$qInstrumen = "SELECT a.instrumen_sub_id, a.instrumen_sub_name " . 
						"FROM " . 
						$simplePAGE['tableprefix']."instrumen_sub AS a " .
						"WHERE " .
						"instrumen_id = '$instrumen_id' " .
						"AND a.instrumen_nologin = '1'";

//echo $qInstrumen;

$fInstrumen = $database->simpleDB_queryinput($qInstrumen);

//echo count($fInstrumen);

if(count($fInstrumen) == 0)
{
?>
<?php
}
else
{
?>
                
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">Pilih Jenis Sub Instrumen</label>
                  <div class="col-sm-9 form-group">
                  	<select id="ptra_instrumen_sub_id" name="ptra_instrumen_sub_id" class="form-control">
                  		<option>--Jenis Sub Instrumen--</option>
                  		<?php
                  			for($i=0;$i<count($fInstrumen);$i++)
                  			{
													echo '<option value="'.$fInstrumen[$i]['instrumen_sub_id'].'">'.$fInstrumen[$i]['instrumen_sub_name'].'</option>';
												}
                  		?>
                  	</select>
                  </div>
                </div>
<?php
	
}
?>