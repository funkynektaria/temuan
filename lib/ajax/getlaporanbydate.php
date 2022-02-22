<?php 

//echo "ada";
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//print_r($_POST);

//echo "ini terpanggil";
$date = $_POST['date'];

if(isset($_POST['subdit']))
{
	$subdit = $_POST['subdit'];	
}


$dbdate = date("Y-m-d",strtotime($date));

//echo $kode_propinsi;

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

if(isset($subdit))
{
	$querySubdit = "AND d.subdit_id = '$subdit' ";
}
else
{
	$querySubdit = '';
}

$queryReport = "SELECT a.*,b.userREALNAME,d.subdit_name FROM " . 
					$simplePAGE['tableprefix'] . "laporan AS a, " .
					$simplePAGE['tableprefix'] . "user AS b, " .
					$simplePAGE['tableprefix'] . "usertosubdit AS c, " .
					$simplePAGE['tableprefix'] . "subdit AS d " .
					"WHERE a.user_id = b.userID " .
					"AND b.userID = c.user_id " .
					"AND c.subdit_id = d.subdit_id " .
					$querySubdit . 
					"AND DATE(a.laporan_real_datetime) = '$dbdate' " .
					"ORDER BY DATE(a.laporan_real_datetime) DESC, " . 
					"d.subdit_id, TIME(a.laporan_real_datetime) ASC";
							
//echo $queryReport;					
							
$fReport = $database->simpleDB_queryinput($queryReport);

?>
					<div class="row mt-20">
						<div class="col-sm-12 table-header table-header-bg text-center">Laporan yang telah diinput</div>
					</div>
					<div class="row">
						<div class="col-sm-2 table-header table-header-bg">Subdit</div>
						<div class="col-sm-2 table-header table-header-bg">Tanggal Pekerjaan</div>
						<div class="col-sm-3 table-header table-header-bg">Uraian Pekerjaan</div>
						<div class="col-sm-2 table-header table-header-bg">Pelaksana Tugas</div>
						<div class="col-sm-1 table-header table-header-bg">Status</div>
						<div class="col-sm-1 table-header table-header-bg">Berkas</div>
						<div class="col-sm-1 table-header table-header-bg">User</div>	
					</div>
<?php

$item = $fReport;

if($item != 0)
{
	for($i=0;$i<count($item);$i++)
	{
		
		//$instrumen_sub_name = $com_sys->getInstrumenSubName($item[$i]["instrumen_sub_id"]);
		$fontColor = '';
		$telahEdit = '';
		$hasilEdit = '';
		//$instrumen_sub_name = $com_welcome->getInstrumenSubName($item[$i]["instrumen_sub_id"]);
		if($item[$i]["edit_status"] == "telah diganti")
		{
			$fontColor = "font-laporan-diganti";
			$telahEdit = '[Telah di Edit] ';
		}
		if($item[$i]["edit_status"] == "baru")
		{
			$hasilEdit = '<span class="font-hasil-edit">[Hasil Edit]</span> ';
		}
		
		echo '<div class="row table-row-border mt-10 '.$fontColor.'">';
			echo '<div class="col-sm-2 table-data">';
			echo $item[$i]["subdit_name"];
			echo '</div>';
			echo '<div class="col-sm-2 table-data">';
			echo $item[$i]['tanggal_pekerjaan'];
			echo '</div>';
			echo '<div class="col-sm-3 table-data">';
			echo $telahEdit;
			echo $hasilEdit;
			echo $item[$i]["uraian_pekerjaan"];
			echo '</div>';
			echo '<div class="col-sm-2 table-data">';
			echo $item[$i]["pelaksana_tugas"];
			echo '</div>';
			echo '<div class="col-sm-1 table-data">';
			if($item[$i]["status"] == "Selesai")
			{
				echo '<span class="data-selesai'.$fontColor.'">';
			}
			else
			{
				echo '<span class="data-tidak-selesai'.$fontColor.'">';
			}
			echo $item[$i]["status"];
			echo '</div>';
			echo '<div class="col-sm-1 table-data">';
			if(!empty($item[$i]["berkas"]) && $item[$i]["berkas"] != '')
			{
				echo '<a href="openfile.php?file=' . $item[$i]["berkas"] . '">';
				echo '<i class="far fa-file'.$fontColor.'"></i>';	
				echo '</a>';
			}
			//echo $item[$i]["berkas"];
			echo '</div>';
			echo '<div class="col-sm-1 table-data">';
			echo $item[$i]["userREALNAME"];
			echo '</div>';
		echo '</div>';
	}
}
else
{
	?>
	<div class="row">
		<div class="col-sm-12 text-center">Data tidak tersedia</div>
	</div>
	<?php
}
