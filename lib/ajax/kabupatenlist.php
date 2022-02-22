<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}

$prop=($_GET['prop']);
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );
//$link = mysql_connect($simplePAGE['host'], $simplePAGE['username'], $simplePAGE['password']); //changet the configuration in required
//if (!$link) {
//    die('Could not connect: ' . mysql_error());
//}

$query = "SELECT * FROM ".$simplePAGE['tableprefix']."core_kabupaten_kota AS a " .
						"WHERE kode_propinsi = '$prop'";

//echo $query;

$fetchdb = $database->simpleDB_queryinput($query);
//echo count($fetchdbCheck);
?>
                <div class="col-sm-4"><label>KABUPATEN / KOTA</label></div>
                <div class="col-sm-7 form-group">
                <select class="form-control" name="prb_kabkota" onchange="getKabupatenData(this.value)">
                	<option value="">--</option>
								<?php
								for($iP=0;$iP<count($fetchdb);$iP++)
								{
								?>
              		<option value="<?php echo $fetchdb[$iP]['kode_kab_kota']; ?>"><?php echo $fetchdb[$iP]['kabupaten_kota']; ?></option>
                <?php
                }
								?>
                </select>
								</div>