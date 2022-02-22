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

$nama_sekolah = $_GET['namasekolah'];
$alamat_sekolah = $_GET['alamatsekolah'];
$kode_kab_kota = $_GET['kode_kab_kota'];
$isid = $_GET['pid'];

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

//$queryCheck = "SELECT npsn FROM ".$simplePAGE['tableprefix']."sekolah_data AS a " .
//						"WHERE a.npsn = '$npsn' ";

//echo $queryCheck;

//$fetchdbCheck = $database->simpleDB_queryinput($queryCheck);

$queryJTU = "SELECT kode_kab_kota FROM ".$simplePAGE['tableprefix']."jawabantouser AS a " .
						"WHERE sekolah = '$nama_sekolah' AND " .
						"kode_kab_kota = '$kode_kab_kota' AND " .
						"instrumen_sub_id = '$isid'";

//echo $queryJTU;

$fetchdbJTU = $database->simpleDB_queryinput($queryJTU);
							
//echo $queryKabKota;
//if($fetchdbCheck[0]['npsn'] != '' && ( $fetchdbJTU[0]['kode_kab_kota'] == '' || empty($fetchdbJTU[0]['kode_kab_kota']) )  )
//{
	
if( ($nama_sekolah != ''||!empty($nama_sekolah)) && ($alamat_sekolah!=''||!empty($alamat_sekolah)) )
{
	if( $fetchdbJTU[0]['kode_kab_kota'] != '' || !empty($fetchdbJTU[0]['kode_kab_kota']) )
	{
?>
<div class="row" style="margin-bottom:20px;">
  <div class="col-sm-12 text-center"><span style="font-size:1.2em; color:red; font-weight:700;">Nama Sekolah <?php echo $nama_sekolah; ?> di Kabupaten / Kota yang dipilih sudah diinput </span></div>
</div>
<?php
	}
	else
	{
?>
<div class="row kategori-group mt-20 mb-20">
  <div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12 mt-20">
				Responden
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
					<select name="responden" class="form-control" id="responden" onchange="getRespondenNamaTelpnoNPSN()">
						<option value="">--Responden--</option>
						<option value="Dinas Pendidikan">Dinas Pendidikan</option>
						<option value="Kepala Sekolah">Kepala Sekolah</option>
						<option value="Guru">Guru</option>
						<option value="Orang Tua">Orangtua</option>
						<option value="Masyarakat">Masyarakat</option>
						<option value="Kelompok Adat">Kelompok Adat</option>
						<option value="Kepala Panti">Kepala Panti</option>
					</select>
			</div>
		</div>
	</div>
</div>
<?php
	}
}
?>