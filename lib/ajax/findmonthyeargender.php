<?php 

//echo "ada";
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//echo "ini terpanggil";
$data_bulan = $_GET['mo'];
$data_tahun = $_GET['ye'];
$gender = $_GET['ge'];
$userID = $_GET['ur'];
$instrumenSubID = $_GET['isid'];

//echo $kode_propinsi;

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

//$fJwbToUser = NULL;

$searchIsSet = 0;

if($data_bulan != '**-**' && $gender != '**-**')
{
	$qJwbToUser = "SELECT * FROM ".
				$simplePAGE['tableprefix']."jawabantouser AS a, ".
				$simplePAGE['tableprefix']."user_detail AS b ".
				"WHERE " . 
				"a.npsn = b.npsn ".
				"AND jwbtouser_month = '".$data_bulan."' ".
				"AND jwbtouser_year = '".$data_tahun."' ".
				"AND a.instrumen_sub_id = '".$instrumenSubID."' ".
				"AND a.jwbtouser_gender = '".$gender."' ".
				"AND b.userID = '".$userID."' ";
							
	//echo $qJwbToUser;					
							
	$fJwbToUser = $database->simpleDB_queryinput($qJwbToUser);
	
	$searchIsSet = 1;
}

//echo count($fJwbToUser);
if( $searchIsSet == 1 && count($fJwbToUser) > 0 )
{
	?>
			<div class="row mt-20">
				<div class="col-sm-12 text-center text-danger">
					Data Tahun <?php echo $data_tahun; ?> Bulan <?php echo $simplePAGE['datamonth'][$data_bulan]; ?> dengan Peserta Didik berjenis kelamin <?php echo $gender; ?> sudah ada
				</div>
			</div>
	<?php
}
elseif( $searchIsSet == 1 && count($fJwbToUser) == 0 )
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
else
{
	
}
?>