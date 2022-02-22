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
				Responden
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
					<select name="responden" class="form-control" id="responden" onchange="getRespondenNamaTelpDataBebas()">
						<option value="">--Responden--</option>
						<option value="Dinas Pendidikan">Dinas Pendidikan</option>
						<option value="Kepala Sekolah">Kepala Sekolah</option>
						<option value="Guru">Guru</option>
						<option value="Orang Tua">Orangtua</option>
						<option value="Masyarakat">Masyarakat</option>
						<option value="Kelompok Adat">Kelompok Adat</option>
						<option value="Kepala Panti">Kepala Panti</option>
					</select>
			</div>
		</div>
	</div>
</div>
