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

$week=($_GET['week']);
$datetimenow = date('Y-m-d H:i:s');

//echo "ini";

$weekindays = 7 * $week;
$weekenddays = 7 * ($week - 1);

$lastFridayDate = date('Y-m-d',strtotime('last '.$simplePAGE['lastdaysearch'].' -'.$weekindays. ' days')); 

$lastFridayDate = $lastFridayDate . " 00:00:00";

$newerFridayDate = date('Y-m-d',strtotime('last '.$simplePAGE['lastdaysearch'].' -'.$weekenddays. ' days')); 

$newerFridayDate = $newerFridayDate . " 00:00:00";

$qZonaGet = "SELECT * FROM " . 
			$simplePAGE['tableprefix'] . "zona_corona AS a, " .
			$simplePAGE['tableprefix'] . "usertosubdit AS b, " .
			$simplePAGE['tableprefix'] . "user AS c, " .
			$simplePAGE['tableprefix'] . "subdit AS d " .
			"WHERE a.user_id = b.user_id " . 
			"AND a.user_id = c.userID " .
			"AND b.user_id = c.userID " .
			"AND b.subdit_id = d.subdit_id " .
			"AND DATE(a.covid_datetime) >= '$lastFridayDate' " .
			"AND DATE(a.covid_datetime) < '$newerFridayDate' " .
			"ORDER BY " . 
			"d.subdit_id, TIME(a.covid_datetime) ASC";
			
//echo $qZonaGet;
//SELECT * FROM ditpsd_homereport.zona_corona WHERE covid_datetime >= '2020-06-26 00:00:00' AND user_id = 1082;
	
$fZonaGet = $database->simpleDB_queryinput($qZonaGet);

$item = $fZonaGet;

if(count($item) > 0)
{
	for($i=0;$i<count($item);$i++)
	{
		$zona = $item[$i]['covid_zona'];
		
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
		
		//$instrumen_sub_name = $com_sys->getInstrumenSubName($item[$i]["instrumen_sub_id"])
		
		echo '<div class="row table-row-border mt-10">';
			echo '<div class="col-sm table-data">';
			echo $item[$i]['userREALNAME'];
			echo '</div>';
			echo '<div class="col-sm table-data">';
			echo $item[$i]['subdit_name'];
			echo '</div>';
			echo '<div class="col-sm table-data '.$zonaCss.'">';
			//echo "<span class = '".$zonaCss."'>";
			echo $item[$i]['covid_zona'];
			//echo "</span>";
			echo '</div>';
			echo '<div class="col-sm table-data">';
			echo $item[$i]["covid_datetime"];
			echo '</div>';
		echo '</div>';
	}
}
else
{
	?>
	<div class="row">
		<div class="col-sm text-center">Data tidak tersedia</div>
	</div>
	<?php
}
