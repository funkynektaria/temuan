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
	$querySubdit2 = "AND r.subdit_id = '$subdit' ";
}
else
{
	$querySubdit = '';
	$querySubdit2= '';
}

/*$queryAbsen = "SELECT * FROM "  .
				$simplePAGE['tableprefix'] . "absen AS a, " .
				$simplePAGE['tableprefix'] . "usertosubdit AS b, " . 
				$simplePAGE['tableprefix'] . "user AS c, " . 
				$simplePAGE['tableprefix'] . "subdit AS d " .
				"WHERE a.user_id = b.user_id " .
				"AND a.user_id = c.userID " . 
				"AND b.user_id = c.userID " . 
				"AND b.subdit_id = d.subdit_id " . 
				$querySubdit . 
				"AND DATE(a.absen_datetime) = '$dbdate' " .
				"ORDER BY DATE(a.absen_datetime) DESC, " . 
				"d.subdit_id, TIME(a.absen_datetime) ASC";*/
				
$queryAbsen = "SELECT a.absen_id, a.absen_stat, a.absen_datetime, a.user_id, c.userID, c.userNAME, c.userREALNAME, d.subdit_id, d.subdit_name, a.remove, '*&*^^' AS kegiatan_id " . 
					"FROM " . 
					$simplePAGE['tableprefix'] . "absen AS a,  " .
					$simplePAGE['tableprefix'] . "usertosubdit AS b, " . 
					$simplePAGE['tableprefix'] . "user AS c, " . 
					$simplePAGE['tableprefix'] . "subdit AS d " . 
					"WHERE a.user_id = b.user_id AND a.user_id = c.userID " .  
					"AND b.user_id = c.userID AND b.subdit_id = d.subdit_id " .  
					$querySubdit . 
					"AND DATE(a.absen_datetime) = '$dbdate' " .  
					"UNION " . 
					"SELECT o.kegpeg_id, 'kegiatan', '$dbdate', o.user_id, q.userID, q.userNAME, q.userREALNAME, r.subdit_id, r.subdit_name, 'kegiatan', s.kegiatan_id " . 
					"FROM " .  
					$simplePAGE['tableprefix'] . "kegiatan_pegawai AS o, " .
					$simplePAGE['tableprefix'] . "usertosubdit AS p,  " .
					$simplePAGE['tableprefix'] . "user AS q,  " .
					$simplePAGE['tableprefix'] . "subdit AS r, " .
					$simplePAGE['tableprefix'] . "kegiatan AS s " .
					"WHERE o.user_id = p.user_id AND o.user_id = q.userID " .  
					"AND p.user_id = q.userID AND p.subdit_id = r.subdit_id " .  
					$querySubdit2 . 
					"AND o.kegiatan_id = s.kegiatan_id " .  
					"AND DATE(s.tanggal_mulai) <= '$dbdate' AND DATE(s.tanggal_selesai) >= '$dbdate' " . 
					"AND s.kegiatan_softdelete = '0' " . 
					"ORDER BY DATE(absen_datetime) DESC, subdit_id, absen_stat ASC, TIME(absen_datetime) ASC";
							
//echo $queryAbsen;					
							
$fAbsenRemove = $database->simpleDB_queryinput($queryAbsen);

if($fAbsenRemove)
{
	?>
					<div class="row mt-20">
						<div class="col-sm-12 table-header table-header-bg text-center">Absensi</div>
					</div>
					<div class="row">
						<div class="col-sm-3 table-header table-header-bg">Nama</div>
						<div class="col-sm-3 table-header table-header-bg">Subdit</div>
						<div class="col-sm-2 table-header table-header-bg">Absen Status</div>
						<div class="col-sm-2 table-header table-header-bg">Tanggal Absen</div>
						<div class="col-sm-1 table-header table-header-bg">Waktu Absen</div>
						<div class="col-sm-1 table-header table-header-bg">&nbsp;</div>
					</div>
					<?php

					for($i=0;$i<count($fAbsenRemove);$i++)
					{
						
						//$instrumen_sub_name = $com_sys->getInstrumenSubName($item[$i]["instrumen_sub_id"]);
						
						?>
						<script>
							function getRemove<?php echo $i; ?>(aid)
							{
						    $.ajax({
						    	type: "POST",
						    	url: "lib/ajax/cekabsendirremove.php", 
						    	data:'aid='+aid,
						    	success: function(result){
						      	$("#removeButton<?php echo $i; ?>").html(result);
						    	}
						    });
							}
							
						</script>
						
						
						
						<?php
						
						
						echo '<div class="row table-row-border mt-10">';
							echo '<div class="col-sm-3 table-data">';
							echo $fAbsenRemove[$i]['userREALNAME'];
							echo '</div>';
							echo '<div class="col-sm-3 table-data">';
							echo $fAbsenRemove[$i]['subdit_name'];
							echo '</div>';
							if($fAbsenRemove[$i]["absen_stat"] == "absen datang")
							{
								echo '<div class="col-sm-2 table-data bg-absen-datang">';	
							}
							else
							{
								echo '<div class="col-sm-2 table-data bg-absen-pulang">';
							}
							echo $fAbsenRemove[$i]["absen_stat"];
							echo '</div>';
							echo '<div class="col-sm-2 table-data">';
							echo date("d-m-Y",strtotime($fAbsenRemove[$i]["absen_datetime"]));
							echo '</div>';
							echo '<div class="col-sm-1 table-data">';
							echo date("H:i:s",strtotime($fAbsenRemove[$i]["absen_datetime"]));
							echo '</div>';
							echo '<div class="col-sm-1 table-data" id="removeButton'.$i.'">';
							if($fAbsenRemove[$i]['remove'] == 0)
							{
								echo '<a href="#" class="btn btn-danger btn-sm buttonRemove'.$i.'" onclick=getRemove'.$i.'('.$fAbsenRemove[$i]["absen_id"].')>';	
								echo 'Hapus';
								echo '</a>';
							}
							elseif($fAbsenRemove[$i]['remove'] == 1)
							{
								echo 'Dihapus';
							}
							else
							{
								
							}
							echo '</div>';
						echo '</div>';
					}
}
else
{
	?>
					<div class="row mt-20">
						<div class="col-sm-12 table-header table-header-bg text-center">Absensi</div>
					</div>
					<div class="row">
						<div class="col-sm-3 table-header table-header-bg">Nama</div>
						<div class="col-sm-3 table-header table-header-bg">Subdit</div>
						<div class="col-sm-2 table-header table-header-bg">Absen Status</div>
						<div class="col-sm-2 table-header table-header-bg">Tanggal Absen</div>
						<div class="col-sm-1 table-header table-header-bg">Waktu Absen</div>
						<div class="col-sm-1 table-header table-header-bg">&nbsp;</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">Data tidak tersedia</div>
					</div>
	<?php
}
?>
