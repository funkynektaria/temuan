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

$telp=($_GET['telp']);

include_once("../../simpleconf.php");
							
//echo $queryKabKota;		

if($telp != '' || !empty($telp))
{
?>
						<div class="row">
							<div class="col-sm-12 text-center">
								<button name="p" class="btn btn-info">Lanjutkan</button>
							</div>
						</div>
<?php
}
else
{
?>
						<div class="row" style="margin-bottom:20px;">
              <div class="col-sm-12 text-center"><span style="font-size:1.2em; color:red; font-weight:700;">No telp tidak boleh kosong</span></div>
            </div>
<?php
}
