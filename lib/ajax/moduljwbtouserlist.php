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

$instrumen_sub_id = $_GET['isid'];
$kode_kab_kota = $_GET['kode_kab_kota'];
$kode_propinsi = $_GET['kode_propinsi'];

//print_r($_GET);

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

if($kode_propinsi != "--Nasional--")
{
	$query_kode_propinsi = "AND kode_propinsi = '$kode_propinsi' ";	
}
else
{
	$query_kode_propinsi = '';
}

if($kode_kab_kota != "--Semua--" && $kode_kab_kota != "undefined")
{
	$query_kode_kab_kota = "AND kode_kab_kota = '$kode_kab_kota' ";	
}
else
{
	$query_kode_kab_kota = '';
}




$queryJTU = "SELECT * FROM ".$simplePAGE['tableprefix']."jawabantouser AS a " .
						"WHERE " . 
						//"sekolah = '$nama_sekolah' AND " .
						//"kode_kab_kota = '$kode_kab_kota' AND " .
						"instrumen_sub_id = '$instrumen_sub_id' " .
						$query_kode_propinsi . 
						$query_kode_kab_kota .
						"AND jwbtouser_update = '1' " . 
						"ORDER BY point_100 DESC";

//echo $queryJTU;

$fetchdbJTU = $database->simpleDB_queryinput($queryJTU);

if($instrumen_sub_id == '' || empty($instrumen_sub_id) || $instrumen_sub_id == '--Instrumen--')
{
?>
<div class="row" style="margin-bottom:20px;">
	<div class="col-sm-12 text-center"><span style="font-size:1.2em; color:red; font-weight:700;">Silakan pilih Instrumen yang akan ditampilkan</span></div>
</div>
<?php
}
else
{
	if( $fetchdbJTU[0]['kode_kab_kota'] == '' || empty($fetchdbJTU[0]['kode_kab_kota']) )
	{
	?>
	<div class="row" style="margin-bottom:20px;">
 		<div class="col-sm-12 text-center"><span style="font-size:1.2em; color:red; font-weight:700;">Data yang dicari tidak tersedia</span></div>
	</div>
	<?php
	}
	else
	{
	?>
	<div class="row kategori-group mt-20 mb-20">
  	<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-12">
					<table class="table">
						<thead>
							<tr>
								<th>Sekolah / Lembaga</th>
								<th>Responden</th>
								<th>Propinsi</th>
								<th>Kabupaten / Kota</th>
								<th>Nilai / Pertanyaan</th>
								<th>Nilai (skala 100)</th>
							</tr>
						</thead>
						
						<tbody>
							<?php
							for($i=0;$i<count($fetchdbJTU);$i++)
							{
								echo "<tr>";
								echo "<td>";
								echo $fetchdbJTU[$i]['sekolah'];
								echo "</td>";
								echo "<td>";
								echo $fetchdbJTU[$i]['responden'];
								echo "</td>";
								echo "<td>";
								echo $fetchdbJTU[$i]['propinsi'];
								echo "</td>";
								echo "<td>";
								echo $fetchdbJTU[$i]['kabupaten_kota'];
								echo "</td>";
								echo "<td>";
								echo $fetchdbJTU[$i]['point'];
								echo "/";
								echo $fetchdbJTU[$i]['total_calculable'];
								echo "</td>";
								echo "<td>";
								echo $fetchdbJTU[$i]['point_100'];
								echo "</td>";
								echo "</tr>";
							}
							?>
						</tbody>
						
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
}

	?>