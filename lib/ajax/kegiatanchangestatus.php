<?php
//echo "saya ada";
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
include_once("../../simple/simplesess/simplesess.php");
$mysession = new simpleSESS($simplePAGE['skrxnt']);
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

if(!isset($_SESSION['id']))
{
	exit();
}

//print_r($_POST);

function test_input($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
	}

$pic_kegiatan_id = $_POST['pkid'];
$approval_status = $_POST['stat'];
$approval_alasan = mysqli_real_escape_string($database->simpleDB_connection, test_input($_POST['alas']));

$datetimenow = date("Y-m-d H:i:s");
$user_id = $_SESSION['id'];

$qGetStat = "SELECT approval_status FROM " . $simplePAGE['tableprefix'] . "pic_kegiatan " .
			"WHERE pic_kegiatan_id = ".$pic_kegiatan_id."";
			

$fGetStat = $database->simpleDB_queryinput($qGetStat);

if($fGetStat[0]['approval_status'] != 'approved' )
{
	$qChangeStatus = "UPDATE " . $simplePAGE['tableprefix'] . "pic_kegiatan " .
		"SET " .
		"approval_status = '$approval_status', " .
		"approval_alasan = '$approval_alasan', " .
		"approval_datetime = '$datetimenow', " .
		"approval_user_id = '$user_id' " .
		"WHERE pic_kegiatan_id = $pic_kegiatan_id";

	$fChangeStatus = $database->simpleDB_queryinput($qChangeStatus);

	if ($fChangeStatus)
	{
	   $queryLog = "INSERT INTO ".$simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
								"VALUES " .
								"( 'record change status kegiatan id =".$pic_kegiatan_id."', '".addslashes($qChangeStatus)."', '".date("Y-m-d H:i:s")."', '$user_id' )";
			
			//echo $query;
								
		$fetchdbLog = $database->simpleDB_queryinput($queryLog);
		
		if($approval_status == 'approved')
		{
			$status_ina = '<span class="text-primary">&nbsp;disetujui&nbsp;</span>';
			
			$queryKegiatanName = "SELECT user_id, pic_kegiatan_nama FROM ".$simplePAGE['tableprefix']."pic_kegiatan WHERE pic_kegiatan_id  = '$pic_kegiatan_id'";
			
			//echo $queryKegiatanName;
			
			$fetchdbKegiatanName = $database->simpleDB_queryinput($queryKegiatanName);
			
			$namaKegiatanDB = $fetchdbKegiatanName[0]['pic_kegiatan_nama'];
			
			for($iM=0;$iM<count($fetchdbKegiatanName);$iM++)
			{
				$queryNotif = "INSERT INTO notification (notif_title,notif_category,notif_datetime,user_id) " . 
								"VALUES  " . 
								"('Permohonan Kegiatan: ".$fetchdbKegiatanName[$iM]['pic_kegiatan_nama']." diterima', 'permohonan revisi kegiatan', '$datetimenow', '".$fetchdbKegiatanName[$iM]['user_id']."')";
								
				$fetchdbNotif = $database->simpleDB_queryinput($queryNotif);
			}	
			
			$qKegiatanList = "SELECT * FROM ".$simplePAGE['tableprefix']."kegiatan_pegawai " .
								"WHERE " .
								"kegiatan_id = '$pic_kegiatan_id'";
			
			//echo $qKegiatanList;
								
			$fKegiatanList = $database->simpleDB_queryinput($qKegiatanList);
			
			if (is_array($fKegiatanList) || $fKegiatanList instanceof Countable) 
			{
      	for($iKeg=0;$iKeg<count($fKegiatanList);$iKeg++)
				{
					
					$qInsertToKegiatanStaff = "INSERT INTO ".$simplePAGE['tableprefix']."kegiatan_staff_list " . 
										"(user_id,user_full_name,kegiatan_id,kegpeg_datetime,institusi,nik,eksternal) " .
										"VALUES ".
										"('".$fKegiatanList[$iKeg]['user_id']."', '".$fKegiatanList[$iKeg]['user_full_name']."', '".$fKegiatanList[$iKeg]['kegiatan_id']."', " . 
										"'".$datetimenow."', '".$fKegiatanList[$iKeg]['institusi']."', '".$fKegiatanList[$iKeg]['nik']."', " . 
										"'".$fKegiatanList[$iKeg]['eksternal']."')";
					
					$fInsertToKegiatanStaff = $database->simpleDB_queryinput($qInsertToKegiatanStaff);
					
					$queryNotif = "INSERT INTO ".$simplePAGE['tableprefix']."notification (notif_title,notif_category,notif_datetime,user_id) " . 
									"VALUES  " . 
									"('Anda menjadi peserta Kegiatan: ".$namaKegiatanDB."', 'peserta kegiatan', '$datetimenow', '".$fKegiatanList[$iKeg]['user_id']."')";
									
					$fetchdbNotif = $database->simpleDB_queryinput($queryNotif);
				}
   		}
			
			
		}
		
		elseif($approval_status == 'rejected')
		{
			$status_ina = '<span class="text-danger">&nbsp;ditolak&nbsp;</span>';
			
			$queryUserModule = "SELECT user_id, pic_kegiatan_nama FROM ".$simplePAGE['tableprefix']."pic_kegiatan WHERE pic_kegiatan_id  = '$pic_kegiatan_id'";
			
			//echo $queryUserModule;
			
			$fetchdbUserModule = $database->simpleDB_queryinput($queryUserModule);
			
			for($iM=0;$iM<count($fetchdbUserModule);$iM++)
			{
				$queryNotif = "INSERT INTO ".$simplePAGE['tableprefix']."notification (notif_title,notif_category,notif_datetime,user_id) " . 
								"VALUES  " . 
								"('Permohonan Kegiatan: ".$fetchdbUserModule[$iM]['pic_kegiatan_nama']." ditolak', 'permohonan kegiatan', '$datetimenow', '".$fetchdbUserModule[$iM]['user_id']."')";
								
				$fetchdbNotif = $database->simpleDB_queryinput($queryNotif);
			}	
		}
		else
		{
			$status_ina = '';
		}
	}
	
	echo '<div class="text-center text-muted">Status Kegiatan: '.$status_ina.', data berhasil diperbaharui</div>';
}




?>