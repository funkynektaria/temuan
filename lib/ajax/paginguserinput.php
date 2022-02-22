<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
include_once("../../simpleconf.php");
include_once("../../../simple/simplesess/simplesess.php");

$mysession = new simpleSESS($simplePAGE['skrxnt']);

//print_r($_SESSION);

if(!isset($_SESSION['id']))
{
	die( "You do not allowed to enter this page" );
}

$page=($_GET['page']);

include_once("../../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

function getUserInput($limit, $page)
{	
	global $database, $simplePAGE;
	
	$startlimit = $page * $limit;
	
	$query = "SELECT b.instrumen_sub_name, c.userNAME, a.jwbtouser_date_time," . 
				"a.jwbtouser_month, a.jwbtouser_year, a.jwbtouser_gender, " . 
				"d.sekolah, e.kecamatan, d.kode_kec, f.kabupaten_kota, g.propinsi " . 
				"FROM " . $simplePAGE['tableprefix'] . "jawabantouser AS a " .
				"LEFT JOIN " . $simplePAGE['tableprefix'] . "instrumen_sub AS b ON a.instrumen_sub_id = b.instrumen_sub_id " .
				"LEFT JOIN " . $simplePAGE['tableprefix'] . "`user` AS c ON a.user_id = c.userID " .
				"LEFT JOIN " . $simplePAGE['tableprefix'] . "sekolah_data AS d ON d.npsn = a.npsn " .
				"LEFT JOIN " . $simplePAGE['tableprefix'] . "core_kecamatan AS e ON a.kode_kecamatan = e.kode_kecamatan " .
				"LEFT JOIN (" . $simplePAGE['tableprefix'] . "core_kabupaten_kota AS f 
				LEFT JOIN " . $simplePAGE['tableprefix'] . "core_propinsi AS g ON f.kode_propinsi = g.kode_propinsi ) 
				ON a.kode_kab_kota = f.kode_kab_kota " .
				"WHERE a.jwbtouser_update = '1' " .
				"ORDER BY a.jwbtouser_date_time DESC LIMIT $startlimit, $limit";
					
	//echo $query;
					
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

function getUserInputCount()
{		
	global $database, $simplePAGE;
	$query = "SELECT COUNT(a.jwbtouser_id) AS total " . 
				"FROM " . $simplePAGE['tableprefix'] . "jawabantouser AS a " .
				"WHERE a.jwbtouser_update = '1' ";
					
	//echo $query;
					
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

function getKecamatan($kode_kecamatan)
{
	global $database, $simplePAGE;
	$query = "SELECT kecamatan " .
				"FROM " . $simplePAGE['tableprefix'] . "core_kecamatan AS a " .
				"WHERE a.kode_kecamatan = '$kode_kecamatan'";
	
	
	//echo $query;
			
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

function showPaging( $productCount, $page )
{
	global $simplePAGE;
	$count = $productCount / $simplePAGE['pesertalimit'] ;
	$ceilCount = ceil($count);
	if($ceilCount > 1)
	{
		if(isset($page)) $limitNow = $page;
		else $limitNow = 1;
		
		?>
            <ul class="pagination pull-right">
          <?php
         
					
		if( $limitNow != $ceilCount )
		{
			echo '<li class="page-item"><a class="page-link" href="#" onclick="paginguserinput(limit='.($limitNow + 1).')">Next</a></li>';
		}
		
		if($ceilCount > 5)
		{
			$pagingCount = 5;
		}
		else
		{
			$pagingCount = $ceilCount;
		}
		
		if($page > 3)
		{
			$startPage = $page - 2;
			$pagingCount = $page + 2;
		}
		else
		{
			$startPage = 1;
		}
		
		for($i=$startPage;$i<=$pagingCount;$i++)
		{
			if($i == $page)
			{
				echo '<li class="page-item active"><a class="page-link" href="#" onclick="paginguserinput(limit='.$i.')">'.$i.'</a></li>';
			}
			else
			{
				echo '<li class="page-item"><a class="page-link" href="#" onclick="paginguserinput(limit='.$i.')">'.$i.'</a></li>';
			}
		}
		?>
            </ul>
         <?php
	}                  
}

$instrumenList = getUserInput($simplePAGE['limit'],$page);
	
$countList = getUserInputCount();

$count = $countList[0]['total'];

$item = $instrumenList;

?>
<div class="card-header">Data Hasil Input User</div>
<div class="card-body">
	<div class="row" id="spinner-userinput">
		<div class="col-sm-12 text-center">
			<div class="spinner-border text-danger"></div>
		</div>
	</div>
	<div class="table table-striped table-bordered">
		<table class="table-user-input">
			<thead>
				<tr>
					<th>Nama Instrumen</th><th>Nama User</th><th>Sekolah</th><th>Kecamatan</th><th>Kabupaten/Kota</th><th>Propinsi</th><th>Bln Lap</th><th>Thn Lap</th><th>Gender</th><th>Waktu input</th>
				</tr>
			</thead>
			<?php
			for($i=0;$i<count($item);$i++)
			{
				echo "<tr>";
				echo "<td>";
				echo $item[$i]['instrumen_sub_name'];
				echo "</td>";
				echo "<td>";
				echo $item[$i]['userNAME'];
				echo "</td>";
				echo "<td>";
				echo $item[$i]['sekolah'];
				echo "</td>";
				echo "<td>";
				if(empty($item[$i]['kecamatan']))
				{
					if(!empty($item[$i]['sekolah']))
					{
						$kecamatanArray = getKecamatan($item[$i]['kode_kec']);
						$kecamatan = $kecamatanArray[0]['kecamatan'];
					}
					else
					{
						$kecamatan = '';
					}
				}
				else
				{
					$kecamatan = $item[$i]['kecamatan'];
				}
				echo $kecamatan;
				echo "</td>";
				echo "<td>";
				echo $item[$i]['kabupaten_kota'];
				echo "</td>";
				echo "<td>";
				echo $item[$i]['propinsi'];
				echo "</td>";
				echo "<td>";
				echo $simplePAGE['datamonth'][$item[$i]['jwbtouser_month']];
				echo "</td>";
				echo "<td>";
				echo $item[$i]['jwbtouser_year'];
				echo "</td>";
				echo "<td>";
				echo $item[$i]['jwbtouser_gender'];
				echo "</td>";
				echo "<td>";
				echo $item[$i]['jwbtouser_date_time'];
				echo "</td>";
				echo "</tr>";
			}
			?>
		</table>
		
	</div>
	
</div>
<div class="card-footer">
	<?php showPaging($count, $page); ?>
</div>
