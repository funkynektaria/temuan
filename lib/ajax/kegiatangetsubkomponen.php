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
$komponen_id = $_GET['kid'];

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

$qKomponen = "SELECT komponen_kode FROM ".$simplePAGE['tableprefix']."komponen AS a ".
			"WHERE komponen_id = '$komponen_id' ";
							
//echo $qSubOutput;					
							
$fKomponen = $database->simpleDB_queryinput($qKomponen);

if( !empty($fOutput) && !empty($fSubOutput) && !empty($fKomponen) )
{
	$output_kode = $fOutput[0]['output_kode'];
	$sub_output_kode = $fSubOutput[0]['sub_output_kode'];
	$komponen_kode = $fKomponen[0]['komponen_kode'];

	$qSubKomponen= "SELECT sub_komponen_id, sub_komponen FROM ".$simplePAGE['tableprefix']."sub_komponen AS a ".
				"WHERE output_kode = '$output_kode' AND sub_output_kode = '$sub_output_kode' AND komponen_kode = '$komponen_kode' ";
									
	//echo $qSubKomponen;					
								
	$fSubKomponen = $database->simpleDB_queryinput($qSubKomponen);	

?>
		<select class="form-control" id="sub_komponen_id" name="sub_komponen_id" required>
    	<option value="">--</option>
    	<?php
    		if(!empty($fSubKomponen))
    		{
					for($iSO = 0; $iSO<count($fSubKomponen); $iSO++)
					{
						echo "<option value=\"".$fSubKomponen[$iSO]['sub_komponen_id']."\">".$fSubKomponen[$iSO]['sub_komponen']."</option>\n";
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

