<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
include_once("../../../simpleconf.php");
include_once("../../../simple/simplesess/simplesess.php");

$mysession = new simpleSESS($simplePAGE['skrxnt']);

//print_r($_SESSION);

if(!isset($_SESSION['id']))
{
	die( "You do not allowed to enter this page" );
}

$ip=($_GET['ip']);

//echo $ip;
//echo $np;

include_once("../../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );
//$link = mysql_connect($simplePAGE['host'], $simplePAGE['username'], $simplePAGE['password']); //changet the configuration in required
//if (!$link) {
//    die('Could not connect: ' . mysql_error());
//}

//echo $kd;

function recordLog($logType, $query, $userID, $date)
{
	global $database, $simplePAGE;
	
	$query = "INSERT INTO ".$simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
						"VALUES " .
						"( '$logType', '".addslashes($query)."', '".date("Y-m-d H:i:s")."', '$userID' )";
	
	//echo $query;
						
	$fetchdb = $database->simpleDB_queryinput($query);
	
	return $fetchdb;
}

$queryInformasi = "SELECT * FROM ".$simplePAGE['tableprefix']."posts " .
						"WHERE post_category = '$ip'";
	
	//echo $query;
						
$fetchdbInformasi = $database->simpleDB_queryinput($queryInformasi);

?>
<script src="https://cdn.tiny.cloud/1/zl2jg4dmvzatt7hcv8yoj4e2n07ue0kilv3kr5clao97ar8h/tinymce/5/tinymce.min.js"></script>

<script>
tinymce.init({
	selector:'textarea',
	height : "580px"
});
</script>
<div class="card">
	<div class="card-body">
		<form action="<?php echo $simplePAGE['adminbasename']; ?>index.php?act=site&mode=com_informasiprogas&amode=informasiupdate" method="post">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
					  <label for="title">Judul</label>
					  <input type="text" class="form-control" name="post_title" id="post_title" value="<?php echo $fetchdbInformasi[0]['post_title']; ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
					  <label for="title">Konten</label>
						<textarea name="post_content"><?php echo $fetchdbInformasi[0]['post_content']; ?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<input type="hidden" name="post_id" value="<?php echo $fetchdbInformasi[0]['post_id']; ?>">
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>