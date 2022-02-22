<?php 

//echo "ada";
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//echo "ini terpanggil";
$output_id = $_GET['oid'];
$sub_output_id = $_GET['soid'];

//echo $sub_output_id;

//echo $kode_propinsi;

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$qOutput = "SELECT output_kode FROM ".$simplePAGE['tableprefix']."output AS a ".
			"WHERE output_id = '$output_id' ";
							
//echo $qOutput;					
							
$fOutput = $database->simpleDB_queryinput($qOutput);



$qSubOutput = "SELECT sub_output_kode FROM ".$simplePAGE['tableprefix']."sub_output AS a ".
			"WHERE sub_output_id = '$sub_output_id' ";
							
//echo $qSubOutput;					
							
$fSubOutput = $database->simpleDB_queryinput($qSubOutput);

if(!empty($fOutput) && !empty($fSubOutput))
{
	$output_kode = $fOutput[0]['output_kode'];
	$sub_output_kode = $fSubOutput[0]['sub_output_kode'];

	$qKomponen= "SELECT komponen_id, komponen FROM ".$simplePAGE['tableprefix']."komponen AS a ".
				"WHERE output_kode = '$output_kode' AND sub_output_kode = '$sub_output_kode' ";
									
	//echo $qKomponen;					
								
	$fKomponen = $database->simpleDB_queryinput($qKomponen);	

?>
		<select class="form-control" id="komponen_id" name="komponen_id" onchange="getSubKomponen(this.value)" required>
    	<option value="">--</option>
    	<?php
    		if(!empty($fKomponen))
    		{
					for($iSO = 0; $iSO<count($fKomponen); $iSO++)
					{
						echo "<option value=\"".$fKomponen[$iSO]['komponen_id']."\">".$fKomponen[$iSO]['komponen']."</option>\n";
					}
				}
			?>
    </select>
<?php
}
else
	
{
	?>
		<select class="form-control" id="sub_output_id" name="sub_output_id">
			<option>--</option>
		</select>
	<?php
}

