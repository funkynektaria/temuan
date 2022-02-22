<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
//echo $_GET['npsn'];
$npsnGet=explode("--",($_GET['npsn']));
$npsn = $npsnGet[0];
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );
//$link = mysql_connect($simplePAGE['host'], $simplePAGE['username'], $simplePAGE['password']); //changet the configuration in required
//if (!$link) {
//    die('Could not connect: ' . mysql_error());
//}

//echo $npsn;

if( $npsn != '' || !empty($npsn) )
{
	
	$query = "SELECT * FROM ".$simplePAGE['tableprefix']."sekolah_data_responden a, " .
							$simplePAGE['tableprefix']."core_propinsi b, " .
							$simplePAGE['tableprefix']."core_kabupaten_kota c " .
							"WHERE a.npsn = '$npsn' AND a.kode_prop = b.kode_propinsi AND a.kode_kab_kota = c.kode_kab_kota AND b.kode_propinsi = c.kode_propinsi";
	
	//echo $query;
	
	$fetchdb = $database->simpleDB_queryinput($query);

//echo count($fetchdbCheck);
?>

								<div class="row" style="margin-bottom:20px;">
                  <div class="col-sm-3"><label>NAMA SEKOLAH</label></div>
                  <div class="col-sm-9 form-group"><?php echo $fetchdb[0]['sekolah']; ?></div>
                </div>
                <div class="row">
                  <div class="col-sm-3"><label>ALAMAT</label></div>
                  <div class="col-sm-9 form-group"><textarea name="prb_alamat" class="form-control" ><?php echo $fetchdb[0]['alamat_jalan']; ?></textarea></div>
                </div>
                <div class="row" style="margin-bottom:20px;">
                  <div class="col-sm-3"><label>PROVINSI</label></div>
                  <div class="col-sm-9 form-group"><?php echo $fetchdb[0]['propinsi']; ?></div>
                </div>
                <div class="row" style="margin-bottom:20px;">
                  <div class="col-sm-3"><label>KABUPATEN</label></div>
                  <div class="col-sm-9 form-group"><?php echo $fetchdb[0]['kabupaten_kota']; ?></div>
                </div>
                <div class="row" style="margin-top:15px;">
                	<div class="col-sm-3"><label>NO TELP SEKOLAH</label></div>
                	<div class="col-sm-9 form-group">
                  	<input type="text" name="prb_nohp" class="form-control" value="<?php echo $fetchdb[0]['no_hp']; ?>" />
                    <input type="hidden" name="prb_kode_prop" class="form-control" value="<?php echo $fetchdb[0]['kode_prop']; ?>" />
                    <input type="hidden" name="prb_kode_kab_kota" class="form-control" value="<?php echo $fetchdb[0]['kode_kab_kota']; ?>" />
                    <input type="hidden" name="prb_sekolah_id" class="form-control" value="<?php echo $fetchdb[0]['sekolah_id']; ?>" />
                    <input type="hidden" name="prb_sekolah" class="form-control" value="<?php echo $fetchdb[0]['sekolah']; ?>" />
                  </div>
              	</div>
                
                <hr>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">NAMA RESPONDEN</label>
                  <div class="col-sm-9 form-group"><input type="text" name="prb_namaresponden" class="form-control" <?php if(isset($fetchdb[0]['nama_responden'])) echo "value=\"".$fetchdb[0]['nama_responden']."\""; ?> /></div>
                </div>
                <div class="line"></div>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">NOMOR HP RESPONDEN</label>
                  <div class="col-sm-9 form-group"><input type="text" name="prb_nomorhpresponden" class="form-control" <?php if(isset($fetchdb[0]['nomor_hp_responden'])) echo "value=\"".$fetchdb[0]['nomor_hp_responden']."\""; ?> /></div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">STATUS (NEGERI / SWASTA)</label>
                  <div class="col-sm-9 form-group ">
                  	<label class="col-sm-3 form-control-label" class="radio-inline label-radio">
                    	<input type="radio" name="prb_status" value="N" 
											<?php 
												if($fetchdb[0]['status']=="N") 
												{
													echo "checked=\"checked\"";
												}
												else
												{
													
												}
											?>/>NEGERI
                    </label>
                  	<label class="col-sm-3 form-control-label" class="radio-inline label-radio">
                    	<input type="radio" name="prb_status" value="S"<?php 
												if($fetchdb[0]['status']=="S") 
												{
													echo "checked=\"checked\"";
												}
												else
												{
													
												}
											?> />SWASTA
                    </label>
                  </div>
                </div>
                  
                <hr>
                
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">JUMLAH DANA BOS</label>
                  <div class="col-sm-9">
                  	<div class="row">
                    	<label class="col-sm-1 form-control-label">TW 1:</label>
                      <div class="col-sm-3">
                        <input type="text" name="prb_jmldanabos1" class="form-control trucated" <?php echo "value=\"".$fetchdb[0]['jumlahdanabostw1']."\""; ?> />
                      </div>
                    	<label class="col-sm-1 form-control-label">TW 2:</label>
                      <div class="col-sm-3">
                        <input type="text" name="prb_jmldanabos2" class="form-control" <?php echo "value=\"".$fetchdb[0]['jumlahdanabostw2']."\""; ?> />
                      </div>
                    	<label class="col-sm-1 form-control-label">TW 3:</label>
                      <div class="col-sm-3">
                        <input type="text" name="prb_jmldanabos3" class="form-control" <?php echo "value=\"".$fetchdb[0]['jumlahdanabostw3']."\""; ?> />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">JUMLAH SISWA</label>
                  <div class="col-sm-9">
                  	<div class="row">
                      <label class="col-sm-1 form-control-label">TW 1:</label>
                      <div class="col-sm-3">
                        <input type="text" name="prb_jmlsiswa1" class="form-control numeric" <?php echo "value=\"".$fetchdb[0]['jumlahsiswatw1']."\""; ?> />
                      </div>
                      <label class="col-sm-1 form-control-label">TW 2:</label>
                      <div class="col-sm-3">
                        <input type="text" name="prb_jmlsiswa2" class="form-control numeric" <?php echo "value=\"".$fetchdb[0]['jumlahsiswatw2']."\""; ?> />
                      </div>
                      <label class="col-sm-1 form-control-label">TW 3:</label>
                      <div class="col-sm-3">
                        <input type="text" name="prb_jmlsiswa3" class="form-control numeric" <?php echo "value=\"".$fetchdb[0]['jumlahsiswatw3']."\""; ?> />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">TANGGAL DANA MASUK REKENING</label>
                  <div class="col-sm-9">
                  	<div class="row">
	                    <label class="col-sm-1 form-control-label">TW 1:</label>
                      <div class="col-sm-3">
                        <input type="text" id="prb_tanggaldanamasuk1" name="prb_tanggaldanamasuk1" class="form-control" <?php if($fetchdb[0]['tanggaldanamasuktw1'] != "0000-00-00") echo "value=\"".date("Y-m-d", strtotime($fetchdb[0]['tanggaldanamasuktw1']))."\""; ?> />
                      </div>
  	                  <label class="col-sm-1 form-control-label">TW 2:</label>
                      <div class="col-sm-3">
                        <input type="text" id="prb_tanggaldanamasuk2" name="prb_tanggaldanamasuk2" class="form-control" <?php if($fetchdb[0]['tanggaldanamasuktw2'] != "0000-00-00") echo "value=\"".date("Y-m-d", strtotime($fetchdb[0]['tanggaldanamasuktw2']))."\""; ?> />
                      </div>
    	                <label class="col-sm-1 form-control-label">TW 3:</label>
                      <div class="col-sm-3">
                        <input type="text" id="prb_tanggaldanamasuk3" name="prb_tanggaldanamasuk3" class="form-control" <?php if($fetchdb[0]['tanggaldanamasuktw3'] != "0000-00-00") echo "value=\"".date("Y-m-d", strtotime($fetchdb[0]['tanggaldanamasuktw3']))."\""; ?> />
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">TANGGAL TUGAS</label>
                  <div class="col-sm-9"><input id="prb_tanggaltugas" type="text" name="prb_tanggaltugas" class="form-control" <?php if($fetchdb[0]['tanggal_tugas'] != "0000-00-00 00:00:00") echo "value=\"".date("Y-m-d", strtotime($fetchdb[0]['tanggal_tugas']))."\""; ?> />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">PETUGAS PUSAT</label>
                  <div class="col-sm-9">
                  	<div class="row">
                      <label class="col-sm-1 form-control-label">1.</label>
                      <div class="col-sm-3">
                        <input type="text" name="prb_petugas1" class="form-control" <?php echo "value=\"".$fetchdb[0]['petugas1']."\""; ?> />
                      </div>
                      <label class="col-sm-1 form-control-label">2.</label>
                      <div class="col-sm-3">
                        <input type="text" name="prb_petugas2" class="form-control" <?php echo "value=\"".$fetchdb[0]['petugas2']."\""; ?> />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                	<div class="col-sm-12 form-group text-center">
                 	 	<button class="btn btn-info" name="prb_submit" value="1">KIRIM</button>
                	</div>
                </div>
<?php
}
?>