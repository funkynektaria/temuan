<?php
//echo "saya ada";
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
include_once("../../simple/simplesess/simplesess.php");
$mysession = new simpleSESS($simplePAGE['skrxnt']);
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

if (!isset($_SESSION['id'])) {
	exit();
}

$user_id = $_SESSION['id'];

$temuan_id = $_POST['tid'];

$qTemuanDetail = "SELECT * FROM " .
$simplePAGE['tableprefix'] . "temuan AS a LEFT JOIN " .
$simplePAGE['tableprefix'] . "temuanoleh AS b " .
"ON a.temuanoleh_id = b.temuanoleh_id " .
"WHERE a.temuan_id = '$temuan_id'";

//echo $query;

$fTemuanDetail = $database->simpleDB_queryinput($qTemuanDetail);

$temuan_detail = $fTemuanDetail;

$query = "SELECT * FROM " .
$simplePAGE['tableprefix'] . "temuandokumen AS a " .
"WHERE a.temuan_id = '$temuan_id'";

//echo $query;

$fetchdb = $database->simpleDB_queryinput($query);

$item = $fetchdb;

if (is_iterable($item)) {
	for ($iTem=0;$iTem<count($item);$iTem++) {

		$file_ext = substr(strrchr($item[$iTem]['temuandokumen_loc'],'.'),1);

		echo '<div class="row">';
		echo '<div class="col">';
		echo '<small>';
		echo '<a href="openfile.php?file='.$item[$iTem]['temuandokumen_loc'].'&rename=TEMUAN_'.str_replace(' ', '_', $temuan_detail[0]['temuan_nama']).'_'.($iTem+1).'.'.$file_ext.'" target="_blank">';
		echo $item[$iTem]['temuandokumen_loc'];
		echo '</a>';
		echo '</small>';
		echo '</div>';
		echo '</div>';
	}
}
?>