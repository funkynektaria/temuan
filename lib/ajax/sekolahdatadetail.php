<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
$npsn=($_GET['npsn']);
$instrumen_id = $_GET['pid'];
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );
//$link = mysql_connect($simplePAGE['host'], $simplePAGE['username'], $simplePAGE['password']); //changet the configuration in required
//if (!$link) {
//    die('Could not connect: ' . mysql_error());
//}



$queryCheck = "SELECT npsn FROM ".$simplePAGE['tableprefix']."jawabantouser AS a " .
						"WHERE npsn = '$npsn' AND instrumen_sub_id = '$instrumen_id'";

//echo $queryCheck;

$fetchdbCheck = $database->simpleDB_queryinput($queryCheck);

if(count($fetchdbCheck) > 0)
{
?>
								<div class="row" style="margin-bottom:20px;">
                  <div class="col-sm-12 text-center"><span style="font-size:1.2em; color:red; font-weight:700;">Sekolah dengan NPSN <?php echo $npsn; ?> telah di input</span></div>
                </div>
<?php
}
else
{
$query = "SELECT *, b.propinsi, c.kabupaten_kota FROM ".$simplePAGE['tableprefix']."sekolah_data AS a, " .
						$simplePAGE['tableprefix']."core_propinsi AS b, " .
						$simplePAGE['tableprefix']."core_kabupaten_kota AS c " .
						"WHERE npsn = '$npsn' AND a.kode_prop = b.kode_propinsi AND a.kode_kab_kota = c.kode_kab_kota AND c.kode_propinsi = b.kode_propinsi";

//echo $query;

$fetchdb = $database->simpleDB_queryinput($query);
//echo count($fetchdbCheck);
if(!empty($fetchdb[0]['sekolah']))
{
?>
						<div class="row kategori-group mt-20">
							<div class="col-sm-12">
								<div class="row mt-20">
									<div class="col-sm-6 col-md-3">
										NAMA SEKOLAH
									</div>
									<div class="col-sm-6 col-md-9">
										: <?php echo $fetchdb[0]['sekolah']; ?>
									</div>
								</div>
                <div class="row mt-20">
									<div class="col-sm-6 col-md-3">
										ALAMAT
									</div>
									<div class="col-sm-6 col-md-9">
										: <?php echo $fetchdb[0]['alamat_jalan']; ?>
									</div>
                </div>
                <div class="row mt-20">
									<div class="col-sm-6 col-md-3">
										PROVINSI
									</div>
	                <div class="col-sm-6 col-md-9">
										: <?php echo $fetchdb[0]['propinsi']; ?>
									</div>
                </div>
                <div class="row mt-20">
									<div class="col-sm-6 col-md-3">
										KABUPATEN
									</div>
	                <div class="col-sm-6 col-md-9">
										: <?php echo $fetchdb[0]['kabupaten_kota']; ?>
									</div>
                </div>
            	</div>
            </div>
            
            <div id="submitbutton" class="row">
							<div class="col-sm-12 text-center">
								<button name="p" class="btn btn-info">Lanjutkan</button>
							</div>
						</div>
<?php
	}
}
?>