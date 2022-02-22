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

$npsnStatus = $_GET['npsnstatus'];

include_once("../../simpleconf.php");

include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );
							
//echo $queryKabKota;

if($npsnStatus == "NPSNyes")
{
?>
<div class="row kategori-group mt-20 mb-20">
  <div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12 mt-20">
				NPSN
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<input type="text" class="form-control numeric" id="npsn" name="npsn" onkeyup="getSekolahData(this.value)" />
			</div>
		</div>
	</div>
</div>
<?php
}
elseif($npsnStatus == "NPSNno")
{
?>
<div class="row kategori-group mt-20 mb-20">
  <div class="col-sm-12">
    <div class="row mt-20">
			<div class="col-sm-12">
				Propinsi
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
    		<select name="kode_propinsi" class="form-control" onchange="getKabKotaNoNPSN(this.value)">
    			<option value="">--Propinsi--</option>
			    <?php
			      $queryProp = "SELECT a.kode_propinsi, a.propinsi FROM ".
									$simplePAGE['tableprefix']."core_propinsi AS a ";
						
						//echo $queryProp;					
											
						$fetchdbProp = $database->simpleDB_queryinput($queryProp);
					
						for($jProp=0;$jProp<count($fetchdbProp);$jProp++)
						{
							echo "<option value=\"".$fetchdbProp[$jProp]['kode_propinsi']."\">".$fetchdbProp[$jProp]['propinsi']."</option>\n";
						}
						
					?>
  			</select>
  		</div>
  	</div>
  </div>
</div>
<?php	
}
else
{
	
}
