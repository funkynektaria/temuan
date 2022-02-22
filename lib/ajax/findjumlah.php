<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}

$assetID=($_GET['aid']);
include_once("../../pageconfig.php");
include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );
//$link = mysql_connect($simplePAGE['host'], $simplePAGE['username'], $simplePAGE['password']); //changet the configuration in required
//if (!$link) {
//    die('Could not connect: ' . mysql_error());
//}

$queryJumlah = "SELECT * FROM ".$simplePAGE['tableprefix']."sekolah_asset WHERE sekolah_asset_id = '$assetID'";

//echo $queryJumlah;

$fetchdbJumlah = $database->simpleDB_queryinput($queryJumlah);

?>
<select name="jumlahditerima" class="form-control">
<?php
	for($i=0;$i<$fetchdbJumlah[0]['jumlah'];$i++)
	{
		echo "<option value=\"".($i+1)."\">".($i+1)."</option>";
	}
?>
</select>
