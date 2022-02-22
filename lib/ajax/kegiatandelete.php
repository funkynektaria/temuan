<?php
//print_r($_POST);
	
	
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

include_once("../../simple/simplesess/simplesess.php");
$mysession = new simpleSESS($simplePAGE['skrxnt']);

$kegiatan_id = $_POST['kid'];
$subdit_id = $_SESSION['subdit_id'];

//$qKegiatan = "SELECT tanggal_mulai, tanggal_selesai FROM " .
//			$simplePAGE['tableprefix']."kegiatan AS a " . 
//			"WHERE " . 
//			"kegiatan_id = '$kegiatan_id'";
			
//$fKegiatan = $database->simpleDB_queryinput($qKegiatan);

//$start_date = $fKegiatan[0]['tanggal_mulai'];
//$end_date = $fKegiatan[0]['tanggal_selesai'];

$qKegiatanDelete = "UPDATE ".$simplePAGE['tableprefix']."kegiatan SET ".
			"kegiatan_softdelete = '1' " .
			"WHERE " .
			"kegiatan_id = '$kegiatan_id' ";
							
//echo $qKegPeg;					

$fKegiatanDelete = $database->simpleDB_queryinput($qKegiatanDelete);

$insertStatus = '';

if($fKegiatanDelete)
{
	$insertStatus = '<span class="text-info">Kegiatan berhasil dihapus</span>';
}
else
{
	$insertStatus = '<span class="text-danger">Kegiatan gagal dihapus</span>';
}


$qListKegiatan = "SELECT a.kegiatan_id, a.kegiatan_nama,a.kegiatan_tempat,a.tanggal_mulai,a.tanggal_selesai,a.subdit FROM " . 
					$simplePAGE['tableprefix'] . "kegiatan AS a " .
					"WHERE a.subdit_id = '".$subdit_id."' AND kegiatan_softdelete = '0' ORDER BY a.tanggal_mulai DESC, a.kegiatan_date_created DESC ";
							
//echo $qListKegPeg;					

$fListKegiatan = $database->simpleDB_queryinput($qListKegiatan);

$item = $fListKegiatan;

if(!empty($item))
{
	?>
						<table class="table table-striped">
							<tr><td colspan="6" class="text-center"><?php echo $insertStatus; ?></td></tr>
							<tr>
								<th>Nama Kegiatan</th>
								<th>Tempat</th>
								<th>Subdit</th>
								<th>Tanggal Mulai</th>
								<th>Tanggal Berakhir</th>
							</tr>
							<?php
							if(!empty($item))
							{
								for($i=0;$i<count($item);$i++)
								{
									echo '<tr>';
										echo '<td>';
										echo $item[$i]["kegiatan_nama"];
										echo '</td>';
										echo '<td>';
										echo $item[$i]["kegiatan_tempat"];
										echo '</td>';
										echo '<td>';
										echo $item[$i]["subdit"];
										echo '</td>';
										echo '<td>';
										echo $item[$i]["tanggal_mulai"];
										echo '</td>';
										echo '<td>';
										echo $item[$i]["tanggal_selesai"];
										echo '</td>';
										echo "<td>";
										echo '<a href="'. $simplePAGE['basename'] . 'index.php?act=site&mode='.$_SESSION['mode'].'&amode=tambahpeserta&kid='.$item[$i]["kegiatan_id"].'" class="btn btn-success btn-sm"><i class="fas fa-users"></i></a>';
										echo ' <a href="'. $simplePAGE['basename'] . 'index.php?act=site&mode='.$_SESSION['mode'].'&amode=editkegiatan&kid='.$item[$i]["kegiatan_id"].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
										echo ' <button class="btn btn-danger btn-sm" onClick="kegiatanRemove('.$item[$i]["kegiatan_id"].')"><i class="fas fa-trash-alt"></i></a>';
										echo "</td>";				
									echo '</tr>';
								}
							}
							else
							{
								?>
								<tr>
									<td>Data tidak tersedia</td>
								</tr>
								<?php
							}
							?>
						</table>
	<?php
}

?>