<?php 

//echo "ada";
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//echo "ini terpanggil";

//echo $kode_propinsi;

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

if(isset($_GET['kode_propinsi']))
{
	$kode_propinsi = $_GET['kode_propinsi'];

	$qProp = "SELECT * FROM ".$simplePAGE['tableprefix']."core_propinsi AS a ".
					" WHERE kode_propinsi = '$kode_propinsi' ";
								
	//echo $queryKabKota;					
								
	$fProp = $database->simpleDB_queryinput($qProp);
}
elseif(isset($_GET['kode_kab_kota']))
{
	$kode_kab_kota = $_GET['kode_kab_kota'];
	
	$qKabKota = "SELECT * FROM ".$simplePAGE['tableprefix']."core_kabupaten_kota AS a ".
					" WHERE kode_kab_kota = '$kode_kab_kota' ";
								
	//echo $queryKabKota;					
								
	$fKabKota = $database->simpleDB_queryinput($qKabKota);
	
	$kode_propinsi = $fKabKota[0]['kode_propinsi'];
	$kabupaten_kota = $fKabKota[0]['kabupaten_kota'];

	$qProp = "SELECT * FROM ".$simplePAGE['tableprefix']."core_propinsi AS a ".
					" WHERE kode_propinsi = '$kode_propinsi' ";
								
	//echo $queryKabKota;					
								
	$fProp = $database->simpleDB_queryinput($qProp);
}

function getPropRekap($kode_propinsi,$pertanyaan_id)
{
	global $simplePAGE, $database;
	
	$query = "SELECT SUM(jawaban_value) AS total " .
					"FROM " . $simplePAGE['tableprefix'] . "jawaban AS a,  " .
					$simplePAGE['tableprefix'] . "jawabantouser AS b,  " . 
					$simplePAGE['tableprefix'] . "core_kabupaten_kota AS c  " .
					"WHERE c.kode_propinsi = '$kode_propinsi' " .
					"AND b.kode_kab_kota = c.kode_kab_kota " . 
					"AND a.jwbtouser_id = b.jwbtouser_id " .
					"AND a.pertanyaan_id = '$pertanyaan_id' " . 
					"AND a.jawaban_update = '1' " . 
					"AND b.jwbtouser_update = '1' ";
				
	//echo $query;			
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

function getKabupatenList( $kode_prop )
{
	global $simplePAGE, $database;
	
	$query = "SELECT * " .
					"FROM " . $simplePAGE['tableprefix'] . "core_kabupaten_kota AS a " .
					"WHERE a.kode_propinsi = '$kode_prop'";
				
	//echo $query;			
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

function getJawabantoUserKab($kode_kab_kota)
{
	global $simplePAGE, $database;
	
	$query = "SELECT * " .
					"FROM " . $simplePAGE['tableprefix'] . "jawabantouser AS a " .
					"WHERE a.kode_kab_kota = '$kode_kab_kota' AND jwbtouser_update = '1'";
				
	//echo $query;			
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

function getJawabanKab($jwbtouser_id, $pertanyaan_id)
{
	global $simplePAGE, $database;
	
	$query = "SELECT * " .
					"FROM " . $simplePAGE['tableprefix'] . "jawaban AS a " .
					"WHERE a.jwbtouser_id = '$jwbtouser_id' AND pertanyaan_id = '$pertanyaan_id' AND jawaban_update = '1'";
				
	//echo $query;			
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

function getLastDOwnload()
{
	global $simplePAGE, $database;
	
	$query = "SELECT MAX(datetime_downloaded) AS latest_download " .
					"FROM " . $simplePAGE['tableprefix'] . "download";
				
	//echo $query;			
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

if(isset($_GET['kode_propinsi']))
{
	$titleMessage = 'Tabulasi '. $fProp[0]['propinsi'] .' '.  $simplePAGE['title'];
}
elseif(isset($_GET['kode_kab_kota']))
{
	$titleMessage = 'Tabulasi '. $fKabKota[0]['kabupaten_kota'] .' '.  $simplePAGE['title'];
}

$latestDownload = getLastDownload();
?>

			<div class="row">
				<div class="col-sm-12 text-center">
					<h4><?php echo $titleMessage; ?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-bordered table-responsive">
						<tr>
							<th>&nbsp;</th>
							<th>Jumlah siswa kelas 6 dengan Ijazah Kurikulum 2013 (K-13) di Kabupaten/Kota Anda</th>
							<th>Jumlah siswa kelas 6 dengan Ijazah Kurikulum 2006 (KTSP 2006) di Kabupaten/Kota Anda</th>
							<th>Jumlah siswa kelas 6 dengan Ijazah Satuan Pendidikan Kerjasama di Kabupaten/Kota Anda</th>
							<th></th>
						</tr>
					<?php
						echo "<tr>";
						echo "<td>";
						echo "<strong>";
						echo $fProp[0]['propinsi'];
						echo "</strong>";
						echo "</td>";
						
						if(isset($_GET['kode_propinsi']))
						{
							$propRekap[1] = getPropRekap($kode_propinsi, 12);
							$propRekap[2] = getPropRekap($kode_propinsi, 13);
							$propRekap[3] = getPropRekap($kode_propinsi, 14);
							
							echo "<td align=right><strong>".$propRekap[1][0]['total']."</strong></td>";
							echo "<td align=right><strong>".$propRekap[2][0]['total']."</strong></td>";
							echo "<td align=right><strong>".$propRekap[3][0]['total']."</strong></td>";
						}
						elseif(isset($_GET['kode_kab_kota']))
						{
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
						}
						
						echo "<td>&nbsp;</td>";
						echo "</tr>";
						
						if(isset($_GET['kode_propinsi']))
						{
							$kabupatenList = getKabupatenList($kode_propinsi);	
						}
						else
						{
							$kabupatenList[0]['kode_kab_kota'] = $kode_kab_kota;
							$kabupatenList[0]['kabupaten_kota'] = $kabupaten_kota;
						}
						
						
						for($iK=0;$iK<count($kabupatenList);$iK++)
						{
							echo "<tr>";
							echo "<td style='padding-left:25px;'>";
							echo $kabupatenList[$iK]['kabupaten_kota'];
							echo "</td>";
							
							$jwbtouser = getJawabantoUserKab($kabupatenList[$iK]['kode_kab_kota']);
							
							$warningNewData = '';
							
							//echo $jwbtouser[0]['jwbtouser_date_time'];
							
							if( strtotime($jwbtouser[0]['jwbtouser_date_time']) > strtotime($latestDownload[0]['latest_download']) )
							{
								//echo "disini";
								$warningNewData = '<i class="fas fa-exclamation-circle text-danger"></i>';
							}
							
							$jawaban[1] = getJawabanKab($jwbtouser[0]['jwbtouser_id'], 12);
							$jawaban[2] = getJawabanKab($jwbtouser[0]['jwbtouser_id'], 13);
							$jawaban[3] = getJawabanKab($jwbtouser[0]['jwbtouser_id'], 14);
							$jawaban[4] = getJawabanKab($jwbtouser[0]['jwbtouser_id'], 15);
							
							echo "<td align=right>".$jawaban[1][0]['jawaban_value']."</td>";
							echo "<td align=right>".$jawaban[2][0]['jawaban_value']."</td>";
							echo "<td align=right>".$jawaban[3][0]['jawaban_value']."</td>";
							echo "<td>";
							if($jawaban[4] != NULL || $jawaban[4] != '')
								echo "<a href=# onClick=\"window.open('".$jawaban[4][0]['jawaban_value']."','pagename','resizable,height=700,width=700')\" target=\"_blank\"><i class=\"fas fa-search\"></i></a>";
							echo "</td>";
							echo "<td>";
							echo $warningNewData;
							echo "</td>";
							echo "</tr>";
						}
					?>
					</table>
				</div>
			</div>
