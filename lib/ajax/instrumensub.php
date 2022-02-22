<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}



$instrumen_id=($_GET['ins_id']);
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");

include_once("../../simple/simplesess/simplesess.php");

$mysession = new simpleSESS($simplePAGE['skrxnt']);

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$gid = $_SESSION['groupid'];

$qInstrumen = "SELECT a.instrumen_sub_id, a.instrumen_sub_name FROM ".$simplePAGE['tableprefix']."instrumen_sub AS a, " .
						$simplePAGE['tableprefix'] . "grouptoinstrumen AS b " .
						"WHERE ".
						"b.groupID = '$gid' ".
						"AND a.instrumen_sub_id = b.instrumen_sub_id ".
						"AND a.instrumen_id = '$instrumen_id' AND a.instrumen_nologin = '1'";

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
                  <label class="col-sm-3 form-control-label">Pilih Instrumen</label>
                  <div class="col-sm-9 form-group">
                  	<select name="isid" class="form-control">		
                  		<option>--Instrumen--</option>
                  		<?php
                  			for($iI=0;$iI<count($fInstrumen);$iI++)
                  			{
													echo '<option value="'.$fInstrumen[$iI]['instrumen_sub_id'].'">'.$fInstrumen[$iI]['instrumen_sub_name'].'</option>';
												}
                  		?>
                  	</select>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">&nbsp;</label>
                  <div class="col-sm-9 form-group">
                  	<button type="submit" class="btn btn-info" name="ptra_submit">&nbsp;&nbsp;&nbsp;Pilih&nbsp;&nbsp;&nbsp;</button>
                  </div>
                </div>
<?php
	
}
?>