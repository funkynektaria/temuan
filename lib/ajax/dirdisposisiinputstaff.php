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

$user_id=$_POST['stid'];
$disposisi_id = $_POST['did'];

$qGetStaffByID = "SELECT * FROM ".$simplePAGE['tableprefix']."disposisi_staff " .
				"WHERE disposisi_id = '$disposisi_id' AND staff_user_id = '$user_id'";
				
$fGetStaffByID = $database->simpleDB_queryinput($qGetStaffByID);

//echo $qGetStaffByID;

$qGetUser = "SELECT userREALNAME FROM ".$simplePAGE['tableprefix']."user  " .
					"WHERE  " . 
					"userID = '$user_id' ";
				
	//echo $qGetStaff;			
	$fgetUser = $database->simpleDB_queryinput($qGetUser);

if($fGetStaffByID)
{
	?>
	<div class='row mt-1'>
		<div class='col-sm bg-red-light text-center'>
			<span class="text-danger"><?php echo "Petugas atas nama ".$fgetUser[0]['userREALNAME']." sudah ada"; ?></span>
		</div>
	</div>
	<?php
}
else
{
	


	//echo "ini";

	$qInputStaff = "INSERT INTO ".$simplePAGE['tableprefix']."disposisi_staff (disposisi_id, nama_staff, staff_user_id) " .
					"VALUES " . 
					"('$disposisi_id', '".$fgetUser[0]['userREALNAME']."','$user_id') ";
				
	//echo $qInputStaff;			

	$fInputStaff = $database->simpleDB_queryinput($qInputStaff);

	$qLog = "INSERT INTO ".$simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
							"VALUES " .
							"( 'Tambah Staff Disposisi dis id=".$disposisi_id."', '".addslashes($qInputStaff)."', '".date("Y-m-d H:i:s")."', '".$_SESSION['id']."' )";
		
	//echo $query;
							
	$fLog = $database->simpleDB_queryinput($qLog);
}



$qGetStaff = "SELECT * FROM ".$simplePAGE['tableprefix']."disposisi_staff  " .
				"WHERE  " . 
				"disposisi_id = '$disposisi_id' ";
			
//echo $qGetStaff;			
$fgetStaff = $database->simpleDB_queryinput($qGetStaff);

if($fgetStaff)
{
	?>
	<div class='row mt-1'>
		<div class='col-sm bg-info-light text-center'>
			<span class="text-info"><?php echo "Petugas atas nama ".$fgetUser[0]['userREALNAME']." telah ditambahkan"; ?></span>
		</div>
	</div>
	<?php
	$item = $fgetStaff;
	for($i=0;$i<count($item);$i++)
	{
		echo "<div class='row mt-1'>";
		echo "<div class='col-sm disposisi-staff-bg'>";
		echo $item[$i]['nama_staff'];
		echo "</div>";
		echo "<div class='col-sm-1'>";
		echo "<button class='btn btn-danger btn-sm' onclick=hapusStaff(".$item[$i]['disposisi_staff_id'].")>Hapus</button>";
		echo "</div>";
		echo "</div>";
	}
}
else
{
	
}
?>