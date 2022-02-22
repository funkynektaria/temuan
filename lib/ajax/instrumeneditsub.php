<?php 

if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//echo "ada";
$instrumen_id=($_GET['ins_id']);
$userID = $_GET['uid'];
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");

$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

$qInstrumen = "SELECT a.instrumen_sub_id, b.jwbtouser_id, a.instrumen_sub_name, b.npsn, b.sekolah, b.kode_kab_kota, b.kabupaten_kota, b.kode_kecamatan, b.jwbtouser_month, b.jwbtouser_year, b.jwbtouser_gender, a.instrumen_sub_type " . 
						"FROM " . 
						$simplePAGE['tableprefix']."instrumen_sub AS a, " .
						$simplePAGE['tableprefix']."jawabantouser AS b " .
						"WHERE " .
						"instrumen_id = '$instrumen_id' " .
						"AND a.instrumen_sub_id = b.instrumen_sub_id " .
						"AND a.instrumen_nologin = '1' AND b.user_id = '$userID' AND jwbtouser_update = '1' ORDER BY b.jwbtouser_id DESC";

//echo $qInstrumen;

$fInstrumen = $database->simpleDB_queryinput($qInstrumen);

//echo count($fInstrumen);

if(count($fInstrumen) == 0)
{
?>
<?php
}
else
{
?>
                
                <!--<div class="form-group row">
                  <label class="col-sm-3 form-control-label">Pilih Instrumen</label>
                  <div class="col-sm-9 form-group">
                  	<!--<select name="jwbtouser_id" class="form-control" onchange="getSekolahSub(this.value, )">		
                  		<option>--Instrumen--</option>
                  		<?php
                  			for($iI=0;$iI<count($fInstrumen);$iI++)
                  			{
													echo '<option value="'.$fInstrumen[$iI]['jwbtouser_id'].'">'.$fInstrumen[$iI]['instrumen_sub_name'].'</option>';
												}
                  		?>
                  	</select>
                  	
                  </div>
                </div>-->
                
                <div class="row">
                	<div class="col-sm-12">
                		<table class="table table-striped"
                		<?php
                		for($iI=0;$iI<count($fInstrumen);$iI++)
              			{
              				$sekolahNama = '';
              				
              				/*if(!empty($fInstrumen[$iI]['npsn']) || $fInstrumen[$iI]['npsn']!='')
              				{
												$qSekolah = "SELECT sekolah FROM ".
	              				$simplePAGE['tableprefix']."sekolah_data " .
	              				"WHERE npsn = '".$fInstrumen[$iI]['npsn']."'";
	              				
	              				//echo $qSekolah;
	              				
	              				$fSekolah = $database->simpleDB_queryinput($qSekolah);
	              				
	              				if(count($fSekolah)>0)
	              				{
													$sekolahNama = $fSekolah[0]['sekolah'];
												}
												else
												{
													$sekolahNama = '';
												}
											} //jika di table jawabantouser tidak ada nama sekolah  */
              				
              				
              				
											
											/*$qKabupaten = "SELECT kabupaten_kota FROM ".
              				$simplePAGE['tableprefix']."core_kabupaten_kota " .
              				"WHERE kode_kab_kota = '".$fInstrumen[$iI]['kode_kab_kota']."'";*/
              				
              				//echo $qKabupaten;
              				
              				//$fKabupaten = $database->simpleDB_queryinput($qKabupaten);
              				
              				/*if(count($fKabupaten)>0)
              				{
												$kabupaten_kota = $fKabupaten[0]['kabupaten_kota'];
											}
											else
											{
												$kabupaten_kota = '';
											}*/
											
											/*$qKecamatan = "SELECT kecamatan FROM ".
              				$simplePAGE['tableprefix']."core_kecamatan " .
              				"WHERE kode_kecamatan = '".$fInstrumen[$iI]['kode_kecamatan']."'";
              				
              				//echo $qKabupaten;
              				
              				$fKecamatan = $database->simpleDB_queryinput($qKecamatan);
              				
              				if(count($fKecamatan)>0)
              				{
												$kecamatan = $fKecamatan[0]['kecamatan'];
											}
											else
											{
												$kecamatan = '';
											}*/
											
											$sekolahNama = $fInstrumen[$iI]['sekolah'];
											
											$kabupaten_kota = $fInstrumen[$iI]['kabupaten_kota'];
											
											//$kecamatan = $fInstrumen[$il]['kecamatan'];
											
              				?>
              				<tr>
              					<td>
	              				<?php
												echo $fInstrumen[$iI]['instrumen_sub_name'];
												if($fInstrumen[$iI]['jwbtouser_gender'] != '' || !empty($fInstrumen[$iI]['jwbtouser_gender']))
												{
													echo " -peserta didik " .$fInstrumen[$iI]['jwbtouser_gender'];
												}
												
												?>
												</td>
												<td>
	              				<?php
												echo $sekolahNama;
												?>
												</td>
												<td>
	              				<?php
												echo $kabupaten_kota;
												?>
												</td>
												<!--<td>
	              				<?php
												//echo $kecamatan;
												?>
												</td>-->
												<!--<td>
	              				<?php
												//echo $fInstrumen[$iI]['jwbtouser_year'];
												?>
												</td>-->
												<!--<td>
	              				<?php
	              				//if($fInstrumen[$iI]['jwbtouser_month']>=1 && $fInstrumen[$iI]['jwbtouser_month']<=12)
	              				//{
												//	echo $simplePAGE['datamonth'][$fInstrumen[$iI]['jwbtouser_month']];	
												//}
												
												?>
												</td>-->
												<td>
													<a href="<?php echo $simplePAGE['basename']; ?>index.php?act=site&mode=com_updateinstrumen&amode=openanswer&isid=<?php echo $fInstrumen[$iI]['instrumen_sub_id']; ?>&npsn=<?php echo $fInstrumen[$iI]['npsn']; ?>&kode_kab_kota=<?php echo $fInstrumen[$iI]['kode_kab_kota']; ?>&jwbid=<?php echo $fInstrumen[$iI]['jwbtouser_id']; ?>" class="btn btn-info">Lihat Jawaban</a>
												</td>
												<td>
													<a href="<?php echo $simplePAGE['basename']; ?>index.php?act=site&mode=com_updateinstrumen&amode=getinstrumen&isid=<?php echo $fInstrumen[$iI]['instrumen_sub_id']; ?>&npsn=<?php echo $fInstrumen[$iI]['npsn']; ?>&kode_kab_kota=<?php echo $fInstrumen[$iI]['kode_kab_kota']; ?>&jwbid=<?php echo $fInstrumen[$iI]['jwbtouser_id']; ?>" class="btn btn-success">Edit</a>
												</td>
											</tr>
											<?php
										}
										?>
										</table>
                	</div>
                </div>
                
                <!--<div class="form-group row">
                  <label class="col-sm-3 form-control-label">&nbsp;</label>
                  <div class="col-sm-9 form-group">
                  	<input type="hidden" name="inid" value="<?php echo $instrumen_id; ?>">
                  	<button type="submit" class="btn btn-info" name="ptra_submit">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
                  </div>
                </div>-->
<?php
	
}
?>