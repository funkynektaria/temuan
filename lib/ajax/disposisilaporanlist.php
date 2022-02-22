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

//print_r($_FILES);

//print_r($_SESSION);

$disposisi_id = $_POST['did'];


$query = "SELECT * FROM " .
		$simplePAGE['tableprefix'] . "disposisi_laporan AS a, " .
		$simplePAGE['tableprefix'] . "user AS b " .
		"WHERE " . 
		"(a.staff_user_id = b.userID AND a.disposisi_id = '".$disposisi_id."') ";
//echo $query;

$fetchdb = $database->simpleDB_queryinput($query);

if($fetchdb)
{
	?>
	<div class="table-responsive">
		<table class="table">
			<?php
			for($i=0;$i<count($fetchdb);$i++)
			{
				echo "<tr>";
				echo "<td style='width: 80%'>";
				if( !empty( $fetchdb[$i]['disposisi_laporan_content'] ) )
				{
					echo nl2br($fetchdb[$i]['disposisi_laporan_content']);
				}
				else
				{
					echo "<a href='openfile.php?file=".$fetchdb[$i]['disposisi_laporan_berkas']."' target=_blank>";
					echo $fetchdb[$i]['disposisi_laporan_berkas'];
					echo "</a>";
				}
				echo "</td>";
				echo "<td>";
				echo $fetchdb[$i]['userREALNAME'];
				echo "</td>";
				echo "</tr>";
			}
			?>
		</table>
	</div>
	
	<?php
} 
else 
{
    echo "Data tidak ada";
}


?>