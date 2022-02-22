<?php 

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
							
//echo $queryKabKota;					
?>
<div class="row kategori-group mt-20 mb-20">
  <div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12 mt-20">
				Nama Sekolah / Instansi
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<input type="text" class="form-control" value="" name="sekolah" id="sekolah" onkeyup="getRespondennoNPSN(this.value,alamat_sekolah.value,kode_kab_kota.value)">
			</div>
		</div>
	</div>
</div>
<div class="row kategori-group mt-20 mb-20">
  <div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12 mt-20">
				Alamat
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<textarea class="form-control" value="" name="alamat_sekolah" id="alamat_sekolah" onkeyup="getRespondennoNPSN(sekolah.value,this.value,kode_kab_kota.value)"></textarea>
			</div>
		</div>
	</div>
</div>
