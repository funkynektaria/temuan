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

$error = 0;

if(isset($_POST['pid']) && !empty($_POST['pid']))
{
	$user_id = $_POST['pid'];
}
elseif(isset($_POST['peserta_luar']))
{
	if(empty($_POST['peserta_luar']))
	{
		$error = 1;
		$insertStatus = '<span class="text-danger">Nama Peserta dari Luar harus diisi</span>';
	}
	elseif(empty($_POST['peserta_institusi']))
	{
		$error = 1;
		$insertStatus = '<span class="text-danger">Institusi Peserta dari Luar harus diisi</span>';
	}
	elseif(empty($_POST['peserta_nik']))
	{
		$error = 1;
		$insertStatus = '<span class="text-danger">NIK Peserta dari Luar harus diisi</span>';
	}
	else
	{
		$peserta_luar 			= $_POST['peserta_luar'];
		$peserta_institusi 	= $_POST['peserta_institusi'];
		$peserta_nik			 	= $_POST['peserta_nik'];
	}
}
else
{
	$error = 1;
}
//echo $error;


/*if($error == 1)
{
	echo '<div class="text-center text-danger">'.$errorMsg.'</div>';
	
	//exit();
}*/

if($error == 1)
{
	$insertStatus = '';
}
else
{
	$datetimenow = date("Y-m-d H:i:s");

	$qKegiatan = "SELECT tanggal_mulai, tanggal_selesai FROM " .
				$simplePAGE['tableprefix']."pic_kegiatan AS a " . 
				"WHERE " . 
				"pic_kegiatan_id = '$kegiatan_id'";
				
	$fKegiatan = $database->simpleDB_queryinput($qKegiatan);

	$start_date = $fKegiatan[0]['tanggal_mulai'];
	$end_date = $fKegiatan[0]['tanggal_selesai'];

	$insertStatus = '';
	
	if(isset($user_id))
	{
		$qSearchKegPeg = "SELECT kegpeg_id " . 
					"FROM ".$simplePAGE['tableprefix']."kegiatan_staff_list ".
					"WHERE " .
					"kegiatan_id = '$kegiatan_id' AND user_id = '$user_id' AND kegpeg_softdelete = '0' ";
			
		//echo $qSearchKegPeg;
					
		$fSearchKegPeg = $database->simpleDB_queryinput($qSearchKegPeg);

		if(empty($fSearchKegPeg))
		{
			$qSearchOtherKegAktif = "SELECT * FROM ".
						$simplePAGE['tableprefix']."pic_kegiatan AS a, ".
						$simplePAGE['tableprefix']."kegiatan_staff_list AS b, " . 
						$simplePAGE['tableprefix']."user AS c " . 
						"WHERE a.tanggal_mulai >= '".$start_date."' AND a.tanggal_mulai <= '".$end_date."' " . 
						"AND a.pic_kegiatan_id = b.kegiatan_id " . 
						"AND b.user_id = '$user_id' " . 
						"AND c.groupID <> '3' " .
						"AND c.userID = b.user_id " .
						"AND b.kegpeg_softdelete = '0' ".
						"GROUP BY c.userID" ; 
			
			//echo $qSearchOtherKegAktif;
			
			$fSearchOtherKegAktif = $database->simpleDB_queryinput($qSearchOtherKegAktif);
			
			$qSearchOtherKeg = "SELECT * FROM ".
						$simplePAGE['tableprefix']."pic_kegiatan AS a, ".
						$simplePAGE['tableprefix']."kegiatan_pegawai AS b, " . 
						$simplePAGE['tableprefix']."user AS c " . 
						"WHERE a.tanggal_mulai >= '".$start_date."' AND a.tanggal_mulai <= '".$end_date."' " . 
						"AND a.pic_kegiatan_id = b.kegiatan_id " . 
						"AND b.user_id = '$user_id' " . 
						"AND c.groupID <> '3' " .
						"AND c.userID = b.user_id " .
						"AND b.kegpeg_softdelete = '0' ".
						"GROUP BY c.userID" ; 
			
			//echo $qSearchOtherKeg;
			
			$fSearchOtherKeg = $database->simpleDB_queryinput($qSearchOtherKeg);
			
			if($fSearchOtherKeg || $fSearchOtherKegAktif)
			{
				$insertStatus = '<span class="text-danger">Peserta sudah mengikuti kegiatan '.$fSearchOtherKeg[0]['pic_kegiatan_nama'].'</span>';
			}
			else
			{
				
				$qUser = "SELECT a.userREALNAME  FROM ".
						$simplePAGE['tableprefix']."user AS a WHERE userID = '".$user_id."' ";
										
				//echo $qKegPeg;					

				$fUser = $database->simpleDB_queryinput($qUser);
				
				$qKegPeg = "INSERT INTO ".$simplePAGE['tableprefix']."kegiatan_pegawai (user_id,user_full_name,institusi,kegiatan_id,kegpeg_datetime) ".
						"VALUES " .
						"('$user_id','".$fUser[0]['userREALNAME']."','','$kegiatan_id','$datetimenow')";
										
				//echo $qKegPeg;					

				$fKegPeg = $database->simpleDB_queryinput($qKegPeg);
				
				$qKegAktifPeg = "INSERT INTO ".$simplePAGE['tableprefix']."kegiatan_staff_list (user_id,user_full_name,institusi,kegiatan_id,kegpeg_datetime) ".
						"VALUES " .
						"('$user_id','".$fUser[0]['userREALNAME']."','','$kegiatan_id','$datetimenow')";
										
				//echo $qKegPeg;					

				$fKegAktifPeg = $database->simpleDB_queryinput($qKegAktifPeg);
				
				if($fKegPeg)
				{
					$insertStatus = '<span class="text-info">Peserta berhasil ditambahkan</span>';
				}
				else
				{
					$insertStatus = '<span class="text-danger">Peserta gagal ditambahkan</span>';
				}
			}
			
		}
		else
		{
			$insertStatus = '<span class="text-warning">Peserta sudah ada</span>';
		}
	}
	elseif(isset($peserta_luar))
	{
		$qSearchKegPeg = "SELECT kegpeg_id " . 
					"FROM ".$simplePAGE['tableprefix']."kegiatan_staff_list ".
					"WHERE " .
					"kegiatan_id = '$kegiatan_id' AND nik = '$peserta_nik' AND kegpeg_softdelete = '0' ";
			
		//echo $qSearchKegPeg;
					
		$fSearchKegPeg = $database->simpleDB_queryinput($qSearchKegPeg);

		if(empty($fSearchKegPeg))
		{
			$qSearchOtherKeg = "SELECT * FROM ".
						$simplePAGE['tableprefix']."pic_kegiatan AS a, ".
						$simplePAGE['tableprefix']."kegiatan_pegawai AS b " . 
						"WHERE a.tanggal_mulai >= '".$start_date."' AND a.tanggal_mulai <= '".$end_date."' " . 
						"AND a.pic_kegiatan_id = b.kegiatan_id " . 
						"AND b.nik = '$peserta_nik'";
			
			$fSearchOtherKeg = $database->simpleDB_queryinput($qSearchOtherKeg);
			
			$qSearchOtherKegAktif = "SELECT * FROM ".
						$simplePAGE['tableprefix']."pic_kegiatan AS a, ".
						$simplePAGE['tableprefix']."kegiatan_staff_list AS b " . 
						"WHERE a.tanggal_mulai >= '".$start_date."' AND a.tanggal_mulai <= '".$end_date."' " . 
						"AND a.pic_kegiatan_id = b.kegiatan_id " . 
						"AND b.nik = '$peserta_nik'";
			
			$fSearchOtherKegAktif = $database->simpleDB_queryinput($qSearchOtherKegAktif);
			
			if($fSearchOtherKeg || $fSearchOtherKegAktif)
			{
				$insertStatus = '<span class="text-danger">Peserta sudah mengikuti kegiatan '.$fSearchOtherKeg[0]['pic_kegiatan_nama'].'</span>';
			}
			else
			{
				$qKegPeg = "INSERT INTO ".$simplePAGE['tableprefix']."kegiatan_pegawai (user_full_name,institusi,nik,kegiatan_id,kegpeg_datetime,eksternal) ".
						"VALUES " .
						"('$peserta_luar','$peserta_institusi','$peserta_nik','$kegiatan_id','$datetimenow','yes')";
										
				//echo $qKegPeg;					

				$fKegPeg = $database->simpleDB_queryinput($qKegPeg);
				
				$qKegAktifPeg = "INSERT INTO ".$simplePAGE['tableprefix']."kegiatan_staff_list (user_full_name,institusi,nik,kegiatan_id,kegpeg_datetime,eksternal) ".
						"VALUES " .
						"('$peserta_luar','$peserta_institusi','$peserta_nik','$kegiatan_id','$datetimenow','yes')";
										
				//echo $qKegAktifPeg;					

				$fKegAktifPeg = $database->simpleDB_queryinput($qKegAktifPeg);
				
				if($fKegAktifPeg)
				{
					$insertStatus = '<span class="text-info">Peserta berhasil ditambahkan</span>';
				}
				else
				{
					$insertStatus = '<span class="text-danger">Peserta gagal ditambahkan</span>';
				}
			}
			
		}
		else
		{
			$insertStatus = '<span class="text-warning">Peserta sudah ada</span>';
		}
	}
}

//query old one
//$qListKegPeg = "SELECT d.* FROM " .
//			$simplePAGE['tableprefix']."kegiatan_pegawai AS d ".
//			"WHERE " .
//			"d.kegiatan_id = '$kegiatan_id' " .
//			"AND d.kegpeg_softdelete = '0' " .
//			"ORDER BY d.kegpeg_datetime";
			
//$qListKegPeg = "SELECT d.user_full_name,d.institusi,d.eksternal,d.kegpeg_id,f.pic_nama FROM " .
//			$simplePAGE['tableprefix']."kegiatan_staff_list AS d ".
//			"LEFT JOIN ".$simplePAGE['tableprefix']."usertopic AS e ON d.user_id = e.user_id " .
//			"LEFT JOIN ".$simplePAGE['tableprefix']."pic AS f ON e.pic_id = f.pic_id " .
//			"WHERE " .
//			"d.kegiatan_id = '$kegiatan_id' " .
//			"AND d.kegpeg_softdelete = '0' " .
//			"ORDER BY d.kegpeg_datetime";
	
//$qListKegPeg = "SELECT d.* FROM " .
//			$simplePAGE['tableprefix']."kegiatan_staff_list AS d ".
//			"WHERE " .
//			"d.kegiatan_id = '$kegiatan_id' " .
//			"AND d.kegpeg_softdelete = '0' " .
//			"ORDER BY d.kegpeg_datetime	";
			
$qListKegPeg = "SELECT d.user_full_name,d.institusi,d.eksternal,d.kegpeg_id,f.pic_nama FROM " .
			$simplePAGE['tableprefix']."kegiatan_staff_list AS d ".
			"LEFT JOIN ".$simplePAGE['tableprefix']."usertopic AS e ON d.user_id = e.user_id " .
			"LEFT JOIN ".$simplePAGE['tableprefix']."pic AS f ON e.pic_id = f.pic_id " .
			"WHERE " .
			"d.kegiatan_id = '$kegiatan_id' " .
			"AND d.kegpeg_softdelete = '0' " .
			"GROUP BY d.user_id ".
			"ORDER BY d.kegpeg_datetime";
							
//echo $qListKegPeg;					

$fListKegPeg = $database->simpleDB_queryinput($qListKegPeg);

$item = $fListKegPeg;

if(!empty($item))
{
	?>
	<div class="card">
			<div class="card-header text-center">
				<?php echo $insertStatus; ?>
			</div>
			<div class="card-header">
				<h3>Peserta Kegiatan</h3>
			</div>
			<div class="card-body">
				<div id="displayPesertaKegiatan" class="table-responsive">
					<?php
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
									$subditName = $item[$i]['pic_nama'];
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
				</div>
			</div>
		</div>
	<?php
}

?>