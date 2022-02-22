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

$queryAbsen = "SELECT * FROM "  .
				$simplePAGE['tableprefix'] . "location AS a, " .
				$simplePAGE['tableprefix'] . "usertosubdit AS b, " . 
				$simplePAGE['tableprefix'] . "user AS c, " . 
				$simplePAGE['tableprefix'] . "subdit AS d " .
				"WHERE a.user_id = b.user_id " .
				"AND a.user_id = c.userID " . 
				"AND b.user_id = c.userID " . 
				"AND b.subdit_id = d.subdit_id " . 
				$querySubdit . 
				"AND DATE(a.loc_datetime) = '$dbdate' " .
				"ORDER BY DATE(a.loc_datetime) DESC, " . 
				"d.subdit_id, TIME(a.loc_datetime) ASC";
							
//echo $queryAbsen;					
							
$fAbsenRemove = $database->simpleDB_queryinput($queryAbsen);

if($fAbsenRemove)
{
	?>
					<div class="row mt-20">
						<div class="col-sm-12 table-header table-header-bg text-center mb-1">Lokasi</div>
					</div>
					<div class="row">
						<div class="col-sm-3 table-header table-header-bg">Nama</div>
						<div class="col-sm-2 table-header table-header-bg">Subdit</div>
						<div class="col-sm-2 table-header table-header-bg">Latitude</div>
						<div class="col-sm-2 table-header table-header-bg">Longitude</div>
						<div class="col-sm-3 table-header table-header-bg">Tanggal Waktu</div>
					</div>
					<?php
					
					$item = $fAbsenRemove;
					
					for($i=0;$i<count($item);$i++)
					{
						
						echo '<div class="row table-row-border mt-10">';
							echo '<div class="col-sm-3 table-data">';
							echo $item[$i]['userREALNAME'];
							echo '</div>';
							echo '<div class="col-sm-2 table-data">';
							echo $item[$i]['subdit_name'];
							echo '</div>';
							echo '<div class="col-sm-2 table-data">';
							echo $item[$i]['lat'];
							echo '</div>';
							echo '<div class="col-sm-2 table-data">';
							echo $item[$i]['lon'];
							echo '</div>';
							echo '<div class="col-sm-3 table-data">';
							echo $item[$i]["loc_datetime"];
							echo '</div>';
						echo '</div>';
					}
					
					?>
					<div class="row">
						<div class="col-sm-12 table-header table-header-bg mt-1 p-1 text-right"><a target="_blank" href="geomap.php?d=<?php echo $dbdate; ?><?php if(isset($subdit)){ echo "&subdit=".$subdit.""; } ?> " class="btn btn-primary">Map</a></div>
					</div>
					<?php
}
else
{
	?>
					<div class="row mt-20">
						<div class="col-sm-12 table-header table-header-bg text-center mb-1">Lokasi</div>
					</div>
					<div class="row">
						<div class="col-sm-3 table-header table-header-bg">Nama</div>
						<div class="col-sm-2 table-header table-header-bg">Subdit</div>
						<div class="col-sm-2 table-header table-header-bg">Latitude</div>
						<div class="col-sm-2 table-header table-header-bg">Longitude</div>
						<div class="col-sm-3 table-header table-header-bg">Tanggal Waktu</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">Data tidak tersedia</div>
					</div>
	<?php
}
?>
