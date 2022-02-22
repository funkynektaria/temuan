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

include_once("../../simple/simplesess/simplesess.php");
$mysession = new simpleSESS($simplePAGE['skrxnt']);

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$kegiatan_id = $_SESSION['kegiatan_id'];
$kegpeg_id = $_POST['kpid'];

//$qKegiatan = "SELECT tanggal_mulai, tanggal_selesai FROM " .
//			$simplePAGE['tableprefix']."kegiatan AS a " . 
//			"WHERE " . 
//			"kegiatan_id = '$kegiatan_id'";
			
//$fKegiatan = $database->simpleDB_queryinput($qKegiatan);

//$start_date = $fKegiatan[0]['tanggal_mulai'];
//$end_date = $fKegiatan[0]['tanggal_selesai'];

$qKegAktifPeg = "UPDATE ".$simplePAGE['tableprefix']."kegiatan_staff_list SET ".
			"kegpeg_softdelete = '1' " .
			"WHERE " .
			"kegpeg_id = '$kegpeg_id' ";
							
//echo $qKegAktifPeg;					

$fKegAktifPeg = $database->simpleDB_queryinput($qKegAktifPeg);

$qGetUserIDRemoved = "SELECT user_id FROM ".$simplePAGE['tableprefix']."kegiatan_staff_list ".
			"WHERE " .
			"kegpeg_id = '$kegpeg_id' ";
							
//echo $qKegAktifPeg;					

$fGetUserIDRemoved = $database->simpleDB_queryinput($qGetUserIDRemoved);

$qKegPeg = "UPDATE ".$simplePAGE['tableprefix']."kegiatan_pegawai SET ".
			"kegpeg_softdelete = '1' " .
			"WHERE " .
			"kegiatan_id = '$kegiatan_id' AND user_id = ".$fGetUserIDRemoved[0]['user_id']."";
							
//echo $qKegPeg;					

$fKegPeg = $database->simpleDB_queryinput($qKegPeg);



$insertStatus = '';

if($fKegPeg)
{
	$insertStatus = '<span class="text-info">Peserta berhasil ditambahkan</span>';
}
else
{
	$insertStatus = '<span class="text-danger">Peserta gagal ditambahkan</span>';
}


/*$qListKegPeg = "SELECT d.kegpeg_id, a.userID, a.userREALNAME, c.subdit_name FROM " .
			$simplePAGE['tableprefix']."user AS a, ".
			$simplePAGE['tableprefix']."usertosubdit AS b, ".
			$simplePAGE['tableprefix']."subdit AS c, ".
			$simplePAGE['tableprefix']."kegiatan_pegawai AS d ".
			"WHERE " .
			"d.kegiatan_id = '$kegiatan_id' " .
			"AND a.userID = d.user_id " . 
			"AND a.userID = b.user_id " . 
			"AND b.subdit_id = c.subdit_id " . 
			"AND a.userID = d.user_id " . 
			"AND d.kegpeg_softdelete = '0' " .
			"ORDER BY d.kegpeg_datetime";*/
			
$qListKegPeg = "SELECT d.* FROM " .
			$simplePAGE['tableprefix']."kegiatan_staff_list AS d ".
			"WHERE " .
			"d.kegiatan_id = '$kegiatan_id' " .
			"AND d.kegpeg_softdelete = '0' " .
			"ORDER BY d.kegpeg_datetime";
							
//echo $qListKegPeg;					

$fListKegPeg = $database->simpleDB_queryinput($qListKegPeg);

$item = $fListKegPeg;

if(!empty($item))
{
	?>
	<table class="table table-striped">
		<tr>
			<th>Peserta</th>
			<th>Fungsi</th>
			<th>&nbsp;</th>
		</tr>
		<?php
		for($i=0;$i<count($item);$i++)
		{
			
			if($item[$i]['eksternal'] == 'yes')
			{
				$fullName = $item[$i]['user_full_name'];
				$subditName =  $item[$i]['institusi'];
			}
			elseif($item[$i]['eksternal'] == 'no')
			{
				$fullName = $item[$i]['user_full_name'];
				$subditName = $item[$i]['institusi'];
			}
			else
			{
				$fullName = '';
				$subditName = '';
			}
			
			echo "<tr>";
			echo "<td>";
			echo $fullName;
			echo "</td>";
			echo "<td>";
			echo $subditName;
			echo "</td>";
			echo "<td>";
			echo '<button class="btn btn-danger btn-sm" onClick="removePeserta('.$item[$i]['kegpeg_id'].')"><i class="fas fa-user-minus"></i></button>';
			echo "</td>";
			echo "</tr>";
		}
		?>
	</table>
	<?php
}

?>