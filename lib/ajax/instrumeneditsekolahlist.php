<?php 

if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//echo "ada";
$instrumen_sub_id=($_GET['inid']);
$userID = $_GET['uid'];
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");


$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$qInstrumen = "SELECT a.instrumen_sub_id, a.instrumen_sub_type " . 
						"FROM " . 
						$simplePAGE['tableprefix']."instrumen_sub AS a " .
						"WHERE " .
						"a.instrumen_sub_id = '$instrumen_sub_id' ";

//echo $qInstrumen;

$fInstrumen = $database->simpleDB_queryinput($qInstrumen);

if($fInstrumen[0]['instrumen_sub_type'] == "sekolah")
{

	$qInstrumen = "SELECT a.instrumen_sub_id, b.jwbtouser_id, a.instrumen_sub_name " . 
							"FROM " . 
							$simplePAGE['tableprefix']."instrumen_sub AS a, " .
							$simplePAGE['tableprefix']."jawabantouser AS b " .
							"WHERE " .
							"instrumen_id = '$instrumen_id' " .
							"AND a.instrumen_sub_id = b.instrumen_sub_id " .
							"AND a.instrumen_nologin = '1' " .
							"AND b.user_id = '$userID'" . 
							"AND ";

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
	                  <label class="col-sm-3 form-control-label">Pilih Sekolah</label>
	                  <div class="col-sm-9 form-group">
	                  	<select name="jwbtouser_id" class="form-control">		
	                  		<option>--Sekolah--</option>
	                  		<?php
	                  			for($iI=0;$iI<count($fInstrumen);$iI++)
	                  			{
														echo '<option value="'.$fInstrumen[$iI]['jwbtouser_id'].'">'.$fInstrumen[$iI]['instrumen_sub_name'].'</option>';
													}
	                  		?>
	                  	</select>
	                  </div>
	                </div>
	                
	                <div class="form-group row">
	                  <label class="col-sm-3 form-control-label">&nbsp;</label>
	                  <div class="col-sm-9 form-group">
	                  	<input type="hidden" name="inid" value="<?php echo $instrumen_id; ?>">
	                  	<button type="submit" class="btn btn-info" name="ptra_submit">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
	                  </div>
	                </div>
	<?php
		
	}
}
elseif($fInstrumen[0]['instrumen_sub_type'] == "dinas pendidikan")
{
	?>
									<div class="form-group row">
	                  <label class="col-sm-3 form-control-label">&nbsp;</label>
	                  <div class="col-sm-9 form-group">
	                  	<input type="hidden" name="inid" value="<?php echo $instrumen_id; ?>">
	                  	<button type="submit" class="btn btn-info" name="ptra_submit">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
	                  </div>
	                </div>
	<?php
}
?>