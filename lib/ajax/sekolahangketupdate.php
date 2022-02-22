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
	
	$queryJ = "SELECT * FROM ".$simplePAGE['tableprefix']."jawaban_angket a " .
							"WHERE a.npsn = '$npsn' ORDER BY a.pertanyaan_id";
	
	//echo $queryJ;
	
	$fetchdbJ = $database->simpleDB_queryinput($queryJ);
	
	//print_r($fetchdbJ);
	//echo count($fetchdbJ);
	
	$queryP = "SELECT * " .
						"FROM " . $simplePAGE['tableprefix'] . "pertanyaan AS a " .
						"WHERE a.pertanyaan_group = '1' AND instrumen_group = '1' ORDER BY a.pertanyaan_id";
 						
		//echo $query;			
		$fetchdbP = $database->simpleDB_queryinput($queryP);

//echo count($fetchdbCheck);
?>
		<script language="javascript">
		function checkAngket()
							 {
									$('#sekolahAngketUpdateForm').submit(function(e){
										var totalChecked = $("input:radio:checked").size();
										var result = true;
										if( totalChecked != <?php echo $totalAngket; ?>)
										{
											alert("Anda belum menginput seluruh angket\nAnda baru menginput sebanyak: " + totalChecked);
											e.preventDefault(); 
										}
									})
								};	
		</script>

			<div class="card">
        <div class="card-header d-flex align-items-center">
          <h3 class="h4">Angket Sekolah</h3>
        </div>
      
      	<div class="card-body">
        	<form id="sekolahAngket" action="<?php $simplePAGE['basename']; ?>index.php?act=site&mode=com_sekolahupdate&amode=recordsekolahangketupdate" method="post">
          	<div class="row">
            	<div class="col-sm-12">
            		<div class="row pertanyaan-row row-eq-height">
                  <div class="col-sm-2 text-center">
                    <h1>ASPEK</h1>
                  </div>
                  <div class="col-sm-1 text-center">
                    &nbsp;
                  </div>
                  <div class="col-sm-5 text-center">
                    <h1>PARAMETER</h1>
                  </div>
                  <div class="col-sm-2">
                    &nbsp;
                  </div>
                  <div class="col-sm-2">
                    &nbsp;
                  </div>
              	</div>
              	<hr>
            		<?php
    						$aspek = '';
    						for($i=0;$i<count($fetchdbP);$i++)
    						{
    						?>
                <div class="row pertanyaan-row row-eq-height">
                	<div class="col-sm-2 pertanyaan-bg text-center ">
                  	<h3>
                  	<?php 
    								if($aspek == $fetchdbP[$i]['pertanyaan_aspek'])
    								{
    									echo "";
    								}
    								else
    								{
    									echo $fetchdbP[$i]['pertanyaan_aspek'];
    									$aspek = $fetchdbP[$i]['pertanyaan_aspek'];
    								}
    							  ?>
                    </h3>
                  </div>
                  <div class="col-sm-1 pertanyaan-bg text-center">
                  	<?php echo $fetchdbP[$i]['pertanyaan_kode']; ?>
                  </div>
                  <div class="col-sm-5 pertanyaan-bg">
                  	<?php echo $fetchdbP[$i]['pertanyaan_soal']; ?>
                  </div>
                  <?php
									if(count($fetchdbJ)>=37)
									{
										//echo "dor";
										$correct_pertanyaan_id = FALSE;
										$iJ = $i;
										$jawaban_isi = $fetchdbJ[$i]['jawaban_isi'];
										//echo $fetchdbJ[$iJ]['pertanyaan_id'];
										/*while($correct_pertanyaan_id == FALSE)
										{
											if($fetchdbP[$i]['pertanyaan_id'] == $fetchdbJ[$iJ]['pertanyaan_id'])
											{
												$correct_pertanyaan_id == TRUE;
												
											}
											else
											{
												$iJ++;
												if($iJ > 37)
												{
													$iJ = 0;
												}
												elseif($iJ == $i)
												{
													echo "error";
													break;
												}
											}
										}*/
										if($jawaban_isi == 'ya')
										{
									?>
                  <div class="col-sm-2 pertanyaan-bg text-center ">
                  	<input name="<?php echo $fetchdbP[$i]['instrumen_group'] . "-" . $fetchdbP[$i]['pertanyaan_group'] . "-" . $fetchdbP[$i]['pertanyaan_kode'] . "-" . $fetchdbP[$i]['pertanyaan_id']; ?>" type="radio" value="ya" checked /> Ya
                  </div>
                  <div class="col-sm-2 pertanyaan-bg text-center ">
                  	<input name="<?php echo $fetchdbP[$i]['instrumen_group'] . "-" . $fetchdbP[$i]['pertanyaan_group'] . "-" . $fetchdbP[$i]['pertanyaan_kode'] . "-" . $fetchdbP[$i]['pertanyaan_id']; ?>" type="radio" value="tidak" /> Tidak
                  </div>
                  <?php
										}
										elseif($jawaban_isi == 'tidak')
										{
									?>
                  <div class="col-sm-2 pertanyaan-bg text-center ">
                  	<input name="<?php echo $fetchdbP[$i]['instrumen_group'] . "-" . $fetchdbP[$i]['pertanyaan_group'] . "-" . $fetchdbP[$i]['pertanyaan_kode'] . "-" . $fetchdbP[$i]['pertanyaan_id']; ?>" type="radio" value="ya" /> Ya
                  </div>
                  <div class="col-sm-2 pertanyaan-bg text-center ">
                  	<input name="<?php echo $fetchdbP[$i]['instrumen_group'] . "-" . $fetchdbP[$i]['pertanyaan_group'] . "-" . $fetchdbP[$i]['pertanyaan_kode'] . "-" . $fetchdbP[$i]['pertanyaan_id']; ?>" type="radio" value="tidak" checked /> Tidak
                  </div>
                  <?php											
										}
										else
										{
									?>
                  <div class="col-sm-2 pertanyaan-bg text-center ">
                  	<input name="<?php echo $fetchdbP[$i]['instrumen_group'] . "-" . $fetchdbP[$i]['pertanyaan_group'] . "-" . $fetchdbP[$i]['pertanyaan_kode'] . "-" . $fetchdbP[$i]['pertanyaan_id']; ?>" type="radio" value="ya" /> Ya
                  </div>
                  <div class="col-sm-2 pertanyaan-bg text-center ">
                  	<input name="<?php echo $fetchdbP[$i]['instrumen_group'] . "-" . $fetchdbP[$i]['pertanyaan_group'] . "-" . $fetchdbP[$i]['pertanyaan_kode'] . "-" . $fetchdbP[$i]['pertanyaan_id']; ?>" type="radio" value="tidak" /> Tidak
                  </div>
                  <?php	
										}
									}
									else
									{
									?>
                  <div class="col-sm-2 pertanyaan-bg text-center ">
                  	<input name="<?php echo $fetchdbP[$i]['instrumen_group'] . "-" . $fetchdbP[$i]['pertanyaan_group'] . "-" . $fetchdbP[$i]['pertanyaan_kode'] . "-" . $fetchdbP[$i]['pertanyaan_id']; ?>" type="radio" value="ya" /> Ya
                  </div>
                  <div class="col-sm-2 pertanyaan-bg text-center ">
                  	<input name="<?php echo $fetchdbP[$i]['instrumen_group'] . "-" . $fetchdbP[$i]['pertanyaan_group'] . "-" . $fetchdbP[$i]['pertanyaan_kode'] . "-" . $fetchdbP[$i]['pertanyaan_id']; ?>" type="radio" value="tidak" /> Tidak
                  </div>
                  <?php
									}
									?>
                </div>
                <?php
    					}					
    					?>
              <div class="row">
                <div class="col-sm-12 form-group text-center">
                	<input type="hidden" name="npsn" value="<?php echo $npsn; ?>" />
                  <input type="hidden" name="neworupdate" value="<?php
									 	if(count($fetchdbJ)>=37)
										{
											echo "update";
										}
										else
										{
											echo "new";
										}
									?>" />
                  <button class="btn btn-info" name="prb_angketsubmit" value="1" onMouseDown="checkAngket();">KIRIM</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
<?php
}
?>