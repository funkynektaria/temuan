<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}

include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
include_once("../../simple/simplesess/simplesess.php");
$mysession = new simpleSESS($simplePAGE['skrxnt']);
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$zona=($_POST['zn']);
$user_id = $_SESSION['id'];
$datetimenow = date('Y-m-d H:i:s');

//echo "ini";

$qZonasiSet = "INSERT INTO " .
				$simplePAGE['tableprefix'] . "zona_corona (covid_zona, covid_datetime, user_id) " .
				"VALUES " . 
				"('".$zona."','".$datetimenow."','".$user_id."') ";
			
//echo $qZonasiSet;			
$fZonasiSet = $database->simpleDB_queryinput($qZonasiSet);

if($fZonasiSet)
{
?>
			<ul class="list-unstyled">
				<li class="btn-absen">
					<div class="card">
						<div class="card-header text-center">
							Anda tinggal di Zona <?php
							 	if($zona == 'Merah')
							 	{
							 		$zonaCss = "zona-merah";
							 	}
							 	elseif($zona == 'Kuning')
							 	{
							 		$zonaCss = "zona-kuning";
							 	}
							 	elseif($zona == 'Hijau')
							 	{
							 		$zonaCss = "zona-hijau";
							 	}
							 	else
							 	{
									$zonaCss = '';
								}
							 	
							 	echo "<span class = '".$zonaCss."'>";
							 	echo $zona;	
							 	echo "</span>";
							 	?>
						</div>
					</div>
				</li>
			</ul>
<?php
}
else
{
?>
			<ul class="list-unstyled">
				<li class="btn-absen">
					<div class="card">
						<div class="card-header text-center bg-danger text-white">
							Pilih Zona Tempat Tinggal Anda
						</div>
						<div class="card-body">
							<div class="row mt-1">
								<div class="col-md">
									<button class="btn btn-danger btn-block" onclick="setZonasi('Merah')"><span class="btn-zona-text">Merah</span></button>
								</div>
							</div>
							<div class="row mt-1">
								<div class="col-md">
									<button class="btn btn-warning btn-block" onclick="setZonasi('Kuning')"><span class="btn-zona-text">Kuning</span></button>
								</div>
							</div>
							<div class="row mt-1">
								<div class="col-md">
									<button class="btn btn-success btn-block" onclick="setZonasi('Hijau')"><span class="btn-zona-text">Hijau</span></button>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
<?php
}
?>