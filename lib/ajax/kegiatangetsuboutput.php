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

//echo $kode_propinsi;

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$qOutput = "SELECT output_kode FROM ".$simplePAGE['tableprefix']."output AS a ".
				" WHERE output_id = '$output_id' ";
							
//echo $qOutput;					
							
$fOutput = $database->simpleDB_queryinput($qOutput);

if(!empty($fOutput))
{
	$output_kode = $fOutput[0]['output_kode'];

	$qSubOutput= "SELECT sub_output_id, sub_output FROM ".$simplePAGE['tableprefix']."sub_output AS a ".
				" WHERE output_kode = '$output_kode'";
								
	//echo $qSubOutput;					
							
	$fSubOutput = $database->simpleDB_queryinput($qSubOutput);	

?>
		<select class="form-control" id="sub_output_id" name="sub_output_id" onchange="getKomponen(this.value)" required>
    	<option value="">--</option>
    	<?php
    		if(!empty($fSubOutput))
    		{
					for($iSO = 0; $iSO<count($fSubOutput); $iSO++)
					{
						echo "<option value=\"".$fSubOutput[$iSO]['sub_output_id']."\">".$fSubOutput[$iSO]['sub_output']."</option>\n";
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

