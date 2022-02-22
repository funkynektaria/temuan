<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}

$kode_kab_kota=($_GET['kdkab']);
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );
//$link = mysql_connect($simplePAGE['host'], $simplePAGE['username'], $simplePAGE['password']); //changet the configuration in required
//if (!$link) {
//    die('Could not connect: ' . mysql_error());
//}

$queryCheck = "SELECT kode_kab_kota FROM ".$simplePAGE['tableprefix']."kabkota_data_responden AS a " .
						"WHERE kode_kab_kota = '$kode_kab_kota'";

//echo $queryCheck;

$fetchdbCheck = $database->simpleDB_queryinput($queryCheck);

if(count($fetchdbCheck) > 0)
{
?>
								<div class="row" style="margin-bottom:20px;">
                  <div class="col-sm-12 text-center"><span style="font-size:1.2em; color:red; font-weight:700;">Kabupaten / Kota yang dipilih telah di input</span></div>
                </div>
<?php
}
else
{

$query = "SELECT * FROM ".$simplePAGE['tableprefix']."kabupaten_kota_detail AS a " .
						"WHERE kode_kab_kota = '$kode_kab_kota'";

//echo $query;

$fetchdb = $database->simpleDB_queryinput($query);

?>

								<div class="row">
                  <div class="col-sm-4"><label>ALAMAT KANTOR</label></div>
                  <div class="col-sm-7 form-group"><textarea name="prb_alamat" class="form-control" ><?php echo stripslashes($fetchdb[0]['alamat_kantor']); ?></textarea>	
                  <input type="hidden" name="prb_kode_kab_kota" value="<?php echo $fetchdb[0]['kode_kab_kota']; ?>" />
                  <input type="hidden" name="prb_kode_propinsi" value="<?php echo $fetchdb[0]['kode_propinsi']; ?>" />
                  </div>
              	</div>
                <div class="row" style="margin-top:15px;">
                  <div class="col-sm-4"><label>NO TELP KANTOR</label></div>
                  <div class="col-sm-7 form-group"><input type="text" name="prb_nohp" class="form-control" /></div>
                </div>
                <div class="row">
                  <div class="col-sm-4"><label>NAMA RESPONDEN</label></div>
                  <div class="col-sm-7 form-group"><input type="text" name="prb_namaresponden" class="form-control" /></div>
                </div>
                <div class="row">
                  <div class="col-sm-4"><label>NOMOR HP RESPONDEN</label></div>
                  <div class="col-sm-7 form-group"><input type="text" name="prb_nomorhpresponden" class="form-control" /></div>
                </div>
                
                
                <div class="row" style="margin-top:20px;">
                  <div class="col-sm-4"><label>TANGGAL</label></div>
                  <div class="col-sm-7 form-group"><input id="prb_tanggaltugas" type="text" name="prb_tanggaltugas" class="form-control" /></div>
                </div>
                <div class="row">
                  <div class="col-sm-4"><label>PETUGAS PUSAT</label></div>
                  <div class="col-sm-3"><label>1.</label><input type="text" name="prb_petugas1" class="form-control" /></div>
                  <div class="col-sm-4"><label>2.</label><input type="text" name="prb_petugas2" class="form-control" /></div>
                </div>
                <div class="row" style="margin-top:40px;">
                  <div class="col-sm-12 form-group text-center">
                    <button class="btn btn-info" name="prb_submit" value="1">KIRIM</button>
                  </div>
                </div>
<?php
}
?>