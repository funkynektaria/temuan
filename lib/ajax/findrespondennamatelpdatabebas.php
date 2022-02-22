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
				Nama Responden
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<input type="text" class="form-control" value="" name="namaResponden" id="namaResponden">
			</div>
		</div>
	</div>
</div>
<div class="row kategori-group mt-20 mb-20">
  <div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12 mt-20">
				Nomor HP Responden
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<input type="text" class="form-control" value="" name="hpResponden" id="hpResponden" onkeyup="getSubmitButton(kode_kab_kota.value, responden.value, this.value)">
			</div>
		</div>
	</div>
</div>
