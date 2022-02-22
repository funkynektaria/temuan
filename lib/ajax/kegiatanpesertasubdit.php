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

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

include_once("../../simple/simplesess/simplesess.php");
$mysession = new simpleSESS($simplePAGE['skrxnt']);

$subdit_id = $_GET['subdit_id'];

//echo $subdit_id;			

if($subdit_id != 'semua')
{
	$querySubdit = "AND c.subdit_id = '".$subdit_id."' ";
}	
else
{
	$querySubdit = '';
}

$qGetPegawaiSubdit = "SELECT a.userID, a.userREALNAME, d.subdit_name, count(b.user_id) AS total FROM " . 
					$simplePAGE['tableprefix'] . "user AS a " .
					"LEFT OUTER JOIN " . $simplePAGE['tableprefix'] . "kegiatan_staff_list AS b ON a.userID = b.user_id, " .
					$simplePAGE['tableprefix'] . "usertosubdit AS c, " .
					$simplePAGE['tableprefix'] . "subdit AS d " .
					"WHERE a.userID = c.user_id AND c.subdit_id = d.subdit_id " . 
					$querySubdit .
					"GROUP BY a.userID ORDER BY total DESC, d.subdit_id ASC "; 

$fGetPegawaiSubdit = $database->simpleDB_queryinput($qGetPegawaiSubdit);

//echo $qGetPegawaiSubdit;

$qCountKegiatan = "SELECT COUNT(*) AS totalKegiatan FROM " . 
					$simplePAGE['tableprefix'] . "kegiatan AS a "; 
					
$fCountKegiatan = $database->simpleDB_queryinput($qCountKegiatan);

$item = $fGetPegawaiSubdit;

$totalKegiatan = $fCountKegiatan[0]['totalKegiatan'];

if(!empty($item))
{
	?>
						<table class="table">
							<tr>
								<th>Pegawai</th>
								<th>Subdit</th>
								<th>Total Kegiatan</th>
								<th width=20%>&nbsp;</th>
							</tr>
							<?php
							if($item != 0)
							{
								for($i=0;$i<count($item);$i++)
								{
									$progressKegiatan = 0;
									if($totalKegiatan != 0)
									{
										$progressKegiatan = round( ($item[$i]['total'] / $totalKegiatan * 100) ,2);
									}
									
									echo "<tr>";
									echo "<td>";
									echo "<a href=\"".$simplePAGE['basename']."index.php?act=site&mode=com_kegiatanlist&amode=detailuser&uid=".$item[$i]['userID']."\">";
									echo $item[$i]['userREALNAME'];
									echo "</a>";
									echo "</td>";
									echo "<td>";
									echo $item[$i]['subdit_name'];
									echo "</td>";
									echo "<td>";
									echo $item[$i]['total'];
									echo "</td>";
									echo "<td>";
									echo '<div class="progress"><div class="progress-bar" style="width:'.$progressKegiatan.'%"></div></div>';
									echo "</td>";
									echo "</tr>";
								}
							}
							else
							{
								?>
								<tr>
									<td colspan="3">Data tidak tersedia</td>
								</tr>
								<?php
							}
							?>
						</table>
	<?php
}

?>