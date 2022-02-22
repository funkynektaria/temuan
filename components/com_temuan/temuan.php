<?php
//echo $_SESSION['groupid'];
defined('CHECK_PAGE_ADMIN_') or die( "You do not allowed to enter this page 1" );

$setDie = 0;
//if( $_SESSION['groupid'] == 1 || $_SESSION['groupid'] == 4 ) 
//{
//	$setDie = 0;
//}


if($setDie == 1)
{
	die( "You do not allowed to enter this page" );
}


class com_sys
{
	
	//configuration vars
	var $simplePAGE = array();
	
	//database object
	var $database;
	
	//sessionobject
	var $mysession;
	
	function __construct( $database , $simplePAGE )
	{
		$this->simplePAGE = $simplePAGE;
		$this->database = $database;
	}
	
	function getTemuanList( )
	{
		
		$query = "SELECT * FROM " . 
					$this->simplePAGE['tableprefix'] . "temuan AS a LEFT JOIN " .
					$this->simplePAGE['tableprefix'] . "temuanoleh AS b " .
					"ON a.temuanoleh_id = b.temuanoleh_id " . 
					"WHERE a.soft_delete IS NULL " .
					"ORDER BY a.temuan_tanggalinput DESC "; 
		
					//echo $query;			
					
		$fetchdb = $this->database->simpleDB_queryinput($query);
		
		//echo $query;
		return $fetchdb;
	}
	
	function getTemuanDetail($temuan_id)
	{
		$query = "SELECT * FROM " .
		$this->simplePAGE['tableprefix'] . "temuan AS a LEFT JOIN " .
		$this->simplePAGE['tableprefix'] . "temuanoleh AS b " .
		"ON a.temuanoleh_id = b.temuanoleh_id " .
		"WHERE a.temuan_id = '$temuan_id'";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		//echo $query;
		return $fetchdb;
	}
	
	function getTinjutDetail($tinjut_id)
	{
		$query = "SELECT * FROM " .
		$this->simplePAGE['tableprefix'] . "tinjut AS a " .
		"WHERE a.tinjut_id = '$tinjut_id'";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		//echo $query;
		return $fetchdb;
	}
	
	function getPenemuTemuan()
	{
		$query = "SELECT * FROM " .
		$this->simplePAGE['tableprefix'] . "temuanoleh AS b ";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		//echo $query;
		return $fetchdb;
	}
	
	function recordTemuan($temuan_nama, $temuan_tanggal, $temuan_deskripsi, $temuan_oleh, $datetimenow, $uid)
	{
		$temuan_tanggal_in_date = date("Y-m-d", $temuan_tanggal);
		
		$query = "insert into " . 
					$this->simplePAGE['tableprefix'] . "temuan " . 
					"(`temuan_nama`, `temuan_deskripsi`, `temuan_tanggal`, `temuan_tanggalinput`, `status`, `temuanoleh_id`, `user_id`) " . 
					"values " . 
					"('$temuan_nama','$temuan_deskripsi','$temuan_tanggal_in_date','$datetimenow','terbuka','$temuan_oleh','$uid')";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		//echo $query;
		return $fetchdb;
		
	}
	
	function recordEditTemuan($temuan_id, $temuan_nama, $temuan_tanggal, $temuan_deskripsi, $temuan_oleh, $datetimenow)
	{
		$temuan_tanggal_in_date = date("Y-m-d", $temuan_tanggal);

		$query = "update " .
		$this->simplePAGE['tableprefix'] . "temuan " .
		"SET `temuan_nama` = '$temuan_nama', " .
		"`temuan_deskripsi` = '$temuan_deskripsi', " . 
		"`temuan_tanggal` = '$temuan_tanggal_in_date', " . 
		"`temuanoleh_id` = '$temuan_oleh' " . 
		"where " .
		"temuan_id = '$temuan_id'";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);
		
		$this->queryLog('update temuan', $query, $_SESSION['id']);

		//echo $query;
		return $fetchdb;
	}
	
	function deleteTemuan($temuan_id)
	{
		$query = "update " .
		$this->simplePAGE['tableprefix'] . "temuan " .
		"SET `soft_delete` = '1' " .
		"where " .
		"temuan_id = '$temuan_id'";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);
		
		$this->queryLog('delete temuan temuan_id='.$temuan_id, $query, $_SESSION['id']);

		//echo $query;
		return $fetchdb;
	}
	
	function deleteTemuanBerkas($temuandokumen_id)
	{
		$query = "update " .
		$this->simplePAGE['tableprefix'] . "temuandokumen " .
		"SET `soft_delete` = '1' " .
		"where " .
		"temuandokumen_id = '$temuandokumen_id'";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		$this->queryLog('delete temuan dokumen temuandokumen_id='.$temuan_id, $query, $_SESSION['id']);

		//echo $query;
		return $fetchdb;
	}
	
	function getDaftarTemuanBerkas($temuan_id)
	{
		$query = "SELECT * FROM " .
		$this->simplePAGE['tableprefix'] . "temuandokumen AS a " .
		"WHERE a.temuan_id = '$temuan_id' AND a.soft_delete ='0'";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		//echo $query;
		return $fetchdb;
	}
	
	function getDaftarTindakLanjut($temuan_id)
	{
		$query = "SELECT * FROM " .
		$this->simplePAGE['tableprefix'] . "tinjut AS a " .
		"WHERE a.temuan_id = '$temuan_id' AND a.soft_delete = '0' ";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		//echo $query;
		return $fetchdb;
	}
	
	function getDaftarTinjutBerkas($tinjut_id)
	{
		$query = "SELECT * FROM " .
		$this->simplePAGE['tableprefix'] . "tinjutdokumen AS a " .
		"WHERE a.tinjut_id = '$tinjut_id'";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		//echo $query;
		return $fetchdb;
	}
	
	function recordTinjut($tinjut_rincian, $tinjut_tanggal, $tinjut_petugas, $temuan_id, $datetimenow, $uid)
	{
		$tinjut_tanggal_in_date = date("Y-m-d", $tinjut_tanggal);

		$query = "insert into " .
		$this->simplePAGE['tableprefix'] . "tinjut " .
		"(`tinjut_rincian`, `tinjut_tanggal`, `tinjut_petugas`, `tinjut_datetime`, `temuan_id`, `user_id`) " .
		"values " .
		"('$tinjut_rincian','$tinjut_tanggal_in_date','$tinjut_petugas','$datetimenow','$temuan_id','$uid')";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		//echo $query;
		return $fetchdb;
	}
	
	function recordEditTinjut($tinjut_rincian, $tinjut_tanggal, $tinjut_petugas, $temuan_id, $tinjut_id, $datetimenow, $uid)
	{
		$tinjut_tanggal_in_date = date("Y-m-d", $tinjut_tanggal);

		$query = "update " .
		$this->simplePAGE['tableprefix'] . "tinjut " .
		"SET " .
		"`tinjut_rincian` = '$tinjut_rincian', " .
		"`tinjut_tanggal` = '$tinjut_tanggal_in_date', " .
		"`tinjut_petugas` = '$tinjut_petugas' " .
		"where " .
		"tinjut_id = '$tinjut_id'";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		$this->queryLog('update tinjut tinjut_id='.$tinjut_id, $query, $_SESSION['id']);

		//echo $query;
		return $fetchdb;
	}
	
	function deleteTinjut($tinjut_id)
	{
		$query = "update " .
		$this->simplePAGE['tableprefix'] . "tinjut " .
		"SET `soft_delete` = '1' " .
		"where " .
		"tinjut_id = '$tinjut_id'";

		//echo $query;

		$fetchdb = $this->database->simpleDB_queryinput($query);

		$this->queryLog('delete tinjut tinjut_id='.$tinjut_id, $query, $_SESSION['id']);

		//echo $query;
		return $fetchdb;
	}
	
	
	function queryLog($log, $query, $user_id)
	{
		$queryLog = "INSERT INTO ".$this->simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
		"VALUES " .
		"( '$log', '".addslashes($query)."', '".date("Y-m-d H:i:s")."', '$user_id' )";

		//echo $query;

		$fetchdbLog = $this->database->simpleDB_queryinput($queryLog);
	}
	
}

$com_sys =  new com_sys( $database , $simplePAGE );

include_once( "components/".$_GET['mode']."/".$act_rep.".html.php" );

include_once( "components/com_temuan/temuan.html.php" ); 

$showHTML = new com_sys_html( $database, $simplePAGE );

$showHTML->showHeader();

if(isset($_GET['amode']) || (isset($error)))
{
	if(((isset($_GET['amode'])) && ($_GET['amode'] == "tambahtemuan")))
	{
		$penemu = $com_sys->getPenemuTemuan();
		
		$showHTML->showFormTambahTemuan($penemu);
	
	}
	elseif (((isset($_GET['amode'])) && ($_GET['amode'] == "temuanedit"))) {
		$temuan_id = $_GET['tid'];
		
		$temuan_detail = $com_sys->getTemuanDetail($temuan_id);
		$penemu = $com_sys->getPenemuTemuan();
		
		$showHTML->showFormEditTemuan($penemu,$temuan_detail);

	}
	elseif (((isset($_GET['amode'])) && ($_GET['amode'] == "recordtemuan"))) 
	{
		//print_r($_POST);
		
		$temuan_nama = $_POST['temuan_nama'];
		$temuan_tanggal = strtotime($_POST['temuan_tanggal']);
		$temuan_deskripsi = $_POST['temuan_deskripsi'];
		$temuan_oleh = $_POST['temuan_oleh'];
		$datetimenow = date("Y-m-d H:i:s");
		
		$recordTemuan = $com_sys->recordTemuan($temuan_nama, $temuan_tanggal, $temuan_deskripsi, $temuan_oleh, $datetimenow, $_SESSION['id']);
		
		$lastID = $database->simpleDB_lastid();
		
		$showHTML->showRedirect($_GET['mode'], 'temuandetail', "&tid=$lastID");
	}
	elseif (((isset($_GET['amode'])) && ($_GET['amode'] == "recordedittemuan")))
	{
		//print_r($_POST);

		$temuan_nama = $_POST['temuan_nama'];
		$temuan_tanggal = strtotime($_POST['temuan_tanggal']);
		$temuan_deskripsi = $_POST['temuan_deskripsi'];
		$temuan_oleh = $_POST['temuan_oleh'];
		$temuan_id = $_POST['temuan_id'];
		$datetimenow = date("Y-m-d H:i:s");

		$recordTemuan = $com_sys->recordEditTemuan($temuan_id, $temuan_nama, $temuan_tanggal, $temuan_deskripsi, $temuan_oleh, $datetimenow, $_SESSION['id']);

		$lastID = $temuan_id;

		$showHTML->showRedirect($_GET['mode'], 'temuandetail', "&tid=$lastID");
	}
	elseif (((isset($_GET['amode'])) && ($_GET['amode'] == "temuandelete")))
	{
		//print_r($_POST);

		$temuan_id = $_GET['tid'];

		$deleteTemuan = $com_sys->deleteTemuan($temuan_id);

		$showHTML->showRedirectHome($_GET['mode']);
	}
	elseif (((isset($_GET['amode'])) && ($_GET['amode'] == "temuanberkasdelete")))
	{
		//print_r($_POST);

		$temuan_id = $_GET['tid'];
		
		$temuandokumen_id = $_GET['tembid'];

		$deleteTemuanBerkas = $com_sys->deleteTemuanBerkas($temuandokumen_id);

		$showHTML->showRedirect($_GET['mode'], 'temuandetail', "&tid=$temuan_id");
		
	}
	elseif(((isset($_GET['amode'])) && ($_GET['amode'] == "temuandetail")))
	{
		$temuan_id = $_GET['tid'];
		
		$temuan_detail = $com_sys->getTemuanDetail($temuan_id);

		$showHTML->showTemuanDetail($temuan_detail);
		
		if($_SESSION['groupid'] == '1')
		{
			$showHTML->showTemuanBerkasAdd();
		}
		
		$daftarTemuanBerkas = $com_sys->getDaftarTemuanBerkas($temuan_id);
		
		$showHTML->showDaftarTemuanBerkas($daftarTemuanBerkas, $temuan_detail);
		
		$daftarTinjut = $com_sys->getDaftarTindakLanjut($temuan_id);
		
		$showHTML->showDaftarTindakLanjut($daftarTinjut, $temuan_id);
		
		//if ($_SESSION['groupid'] == '1') {
		//	$showHTML->showTemuanTindakLanjutAdd();
		//}
	}
	elseif(((isset($_GET['amode'])) && ($_GET['amode'] == "tambahtinjut")))
	{
		$temuan_id = $_GET['tid'];
		$temuan_detail = $com_sys->getTemuanDetail($temuan_id);
		$showHTML->showFormTambahTinjut($temuan_id, $temuan_detail);
		
	}
	elseif(((isset($_GET['amode'])) && ($_GET['amode'] == "tinjuedit")))
	{
		$temuan_id = $_GET['tid'];
		$tinjut_id = $_GET['tinid'];
		$temuan_detail = $com_sys->getTemuanDetail($temuan_id);
		$tinjut_detail = $com_sys->getTinjutDetail($tinjut_id);
		$showHTML->showFormEditTinjut($temuan_id, $temuan_detail,$tinjut_detail);

	}
	
	elseif (((isset($_GET['amode'])) && ($_GET['amode'] == "recordtinjut")))
	{
		//print_r($_POST);

		$tinjut_rincian = $_POST['tinjut_rincian'];
		$tinjut_tanggal = strtotime($_POST['tinjut_tanggal']);
		$tinjut_petugas = $_POST['tinjut_petugas'];
		$temuan_id = $_POST['tid'];
		$datetimenow = date("Y-m-d H:i:s");

		$recordTemuan = $com_sys->recordTinjut($tinjut_rincian, $tinjut_tanggal, $tinjut_petugas, $temuan_id, $datetimenow, $_SESSION['id']);

		$lastID = $database->simpleDB_lastid();

		$showHTML->showRedirect($_GET['mode'], 'tinjutdetail', "&tid=$temuan_id&tinid=$lastID");
	}
	elseif (((isset($_GET['amode'])) && ($_GET['amode'] == "updatetinjut")))
	{
		//print_r($_POST);

		$tinjut_rincian = $_POST['tinjut_rincian'];
		$tinjut_tanggal = strtotime($_POST['tinjut_tanggal']);
		$tinjut_petugas = $_POST['tinjut_petugas'];
		$tinjut_id = $_POST['tinid'];
		$temuan_id = $_POST['tid'];
		$datetimenow = date("Y-m-d H:i:s");

		$recordTemuan = $com_sys->recordEditTinjut($tinjut_rincian, $tinjut_tanggal, $tinjut_petugas, $temuan_id, $tinjut_id, $datetimenow, $_SESSION['id']);

		$lastID = $tinjut_id;

		$showHTML->showRedirect($_GET['mode'], 'tinjutdetail', "&tid=$temuan_id&tinid=$lastID");
	}
	elseif (((isset($_GET['amode'])) && ($_GET['amode'] == "tinjutdelete")))
	{
		//print_r($_POST);

		$temuan_id = $_GET['tid'];
		$tinjut_id = $_GET['tinid'];

		$deleteTemuan = $com_sys->deleteTinjut($tinjut_id);

		$showHTML->showRedirect($_GET['mode'], 'temuandetail', "&tid=$temuan_id");
	}
	elseif(((isset($_GET['amode'])) && ($_GET['amode'] == "tinjutdetail")))
	{
		$temuan_id = $_GET['tid'];
		
		$tinjut_id = $_GET['tinid'];

		$temuan_detail = $com_sys->getTemuanDetail($temuan_id);
		
		$tinjut_detail = $com_sys->getTinjutDetail($tinjut_id);

		$showHTML->showTinjutDetail($tinjut_detail, $temuan_detail);

		if ($_SESSION['groupid'] == '1') {
			$showHTML->showTinjutBerkasAdd();
		}

		$daftarTinjutBerkas = $com_sys->getDaftarTinjutBerkas($tinjut_id);

		$showHTML->showDaftarTinjutBerkas($daftarTinjutBerkas);

		//if ($_SESSION['groupid'] == '1') {
		//	$showHTML->showTemuanTindakLanjutAdd();
		//}
	}
	else
	{
		
	}
	
}
else
{
	$dataList = $com_sys->getTemuanList();
	if ($_SESSION['groupid'] == '1') {
		$showHTML->showTambahTemuan();
	}
	
	$showHTML->showTemuanList($dataList);
}
?>