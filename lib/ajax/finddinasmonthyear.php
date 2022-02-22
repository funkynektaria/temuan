<?php 

//echo "ada";
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

include_once("../../simple/simplesess/simplesess.php");

$mysession = new simpleSESS($simplePAGE['skrxnt']);

//echo "ini terpanggil";
$data_bulan = $_GET['mo'];
$data_tahun = $_GET['ye'];
$userID = $_SESSION['id'];
$instrumenSubID = $_GET['isid'];

//echo $kode_propinsi;



//$fJwbToUser

if($data_bulan != '**-**')
{
	$qJwbToUser = "SELECT * FROM ".
				$simplePAGE['tableprefix']."jawabantouser AS a, ".
				$simplePAGE['tableprefix']."user_detail AS b ".
				"WHERE " . 
				"a.kode_kab_kota = b.kode_kab_kota ".
				"AND jwbtouser_month = '".$data_bulan."' ".
				"AND jwbtouser_year = '".$data_tahun."' ".
				"AND a.instrumen_sub_id = '".$instrumenSubID."' ".
				"AND b.userID = '".$userID."' ";
							
	//echo $qJwbToUser;					
							
	$fJwbToUser = $database->simpleDB_queryinput($qJwbToUser);
}

if(count($fJwbToUser) > 0 )
{
	?>
			<div class="row mt-20">
				<div class="col-sm-12 text-center text-danger">
					Data Tahun <?php echo $data_tahun; ?> Bulan <?php echo $simplePAGE['datamonth'][$data_bulan]; ?> sudah ada
				</div>
			</div>
	<?php
}
else
{
	?>
			<div class="row mt-20">
				<div class="col-sm-12 text-center">
					<input type="hidden" name="instrumen_sub_id" value="<?php echo $instrumenSubID; ?>">
					<input type="hidden" name="page" value="1">
					<button class="btn btn-info" name="Submit">Lanjutkan</button>
				</div>
			</div>
	<?php
}
?>