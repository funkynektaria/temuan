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

$tinjut_id = $_POST['tinid'];


$query = "SELECT * FROM " .
$simplePAGE['tableprefix'] . "tinjutdokumen AS a " .
"WHERE a.tinjut_id = '$tinjut_id'";

//echo $query;

$fetchdb = $database->simpleDB_queryinput($query);

$item = $fetchdb;

if (is_iterable($item)) {
	for ($iTem=0;$iTem<count($item);$iTem++) {

		$file_ext = substr(strrchr($item[$iTem]['tinjutdokumen_loc'],'.'),1);

		echo '<div class="row">';
		echo '<div class="col">';
		echo '<small>';
		echo $item[$iTem]['tinjutdokumen_loc'];
		echo '</small>';
		echo '</div>';
		echo '</div>';
	}
}
?>