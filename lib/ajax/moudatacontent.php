<?php
echo "ini jalann";

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$user_id = $_SESSION['id'];

$queryProp = "SELECT * " .
							"FROM " . $simplePAGE['tableprefix'] . "user_detail AS a " .
							"WHERE a.userID = '$user_id'";
	 						
echo $queryProp;			
$fetchdbProp = $database->simpleDB_queryinput($queryProp);
?>