<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}
$pertanyaan_id=($_GET['pid']);
$kode_propinsi=($_GET['propid']);
$kode_kab_kota=($_GET['kabid']);
include_once("../../simpleconf.php");
include_once("../../simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

//echo "ini";

function getPertanyaanPoint( $pertanyaan_id )
{
	global $simplePAGE, $database;
	$query = "SELECT * " .
					"FROM " . $simplePAGE['tableprefix'] . "pertanyaan_point AS a " .
					"WHERE a.pertanyaan_id = '$pertanyaan_id'";
				
	//echo $query;			
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

function getInstrumenType( $pertanyaan_id )
{
	global $simplePAGE, $database;
	$query = "SELECT c.instrumen_sub_type " .
				"FROM " . 
				$simplePAGE['tableprefix'] . "jawaban AS a, " .
				$simplePAGE['tableprefix'] . "jawabantouser AS b, " . 
				$simplePAGE['tableprefix'] . "instrumen_sub AS c " .
				"WHERE a.jwbtouser_id = b.jwbtouser_id " . 
				"AND b.instrumen_sub_id = c.instrumen_sub_id " . 
				"AND a.pertanyaan_id = '$pertanyaan_id'";
	//echo $query;			
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

function getCountJawabanPoint($pertanyaan_id, $pertanyaan_point_value)
{
	global $simplePAGE, $database;
	$query = "SELECT COUNT(*) AS total " .
					"FROM " . $simplePAGE['tableprefix'] . "jawaban AS a " .
					"WHERE a.jawaban_id IN " . 
					"(SELECT MAX(jawaban_id) " . 
					"FROM " . $simplePAGE['tableprefix'] . "jawaban AS b, " .
					$simplePAGE['tableprefix'] . "jawabantouser AS c " .
					"WHERE b.pertanyaan_id = '$pertanyaan_id' AND " .
					"b.jawaban_value = '".trim($pertanyaan_point_value)."' " . 
					"AND b.jwbtouser_id = c.jwbtouser_id AND c.jwbtouser_update = '1' " .
					"GROUP BY b.jwbtouser_id)";
				
	//echo $query;
	$fetchdb = $database->simpleDB_queryinput($query);
	//print_r($fetchdb);
	//echo $fetchdb[0]['total'];
	if($fetchdb[0]['total'] != NULL)
	{
		return $fetchdb[0]['total'];
	}
	else
	{
		//echo "ini";
		return 0;
		
	}
}

function getSekolahList($pertanyaan_id)
{
	global $simplePAGE, $database;
	$query = "SELECT MAX(jawaban_id), jawaban_value, b.jwbtouser_id, c.npsn, d.sekolah, e.kabupaten_kota, f.propinsi " .
					"FROM " . $simplePAGE['tableprefix'] . "jawaban AS b, " .
					$simplePAGE['tableprefix'] . "jawabantouser AS c, " .
					$simplePAGE['tableprefix'] . "sekolah_data AS d, " . 
					$simplePAGE['tableprefix'] . "core_kabupaten_kota AS e, " . 
					$simplePAGE['tableprefix'] . "core_propinsi AS f " .
					"WHERE b.pertanyaan_id = '$pertanyaan_id' AND b.jwbtouser_id = c.jwbtouser_id " .
					"AND c.npsn = d.npsn AND d.kode_kab_kota = e.kode_kab_kota " . 
					"AND d.kode_prop = f.kode_propinsi AND e.kode_propinsi = f.kode_propinsi " .
					"AND c.jwbtouser_update = '1' " .
					"GROUP BY b.jwbtouser_id " . 
					"ORDER BY f.kode_propinsi, e.kode_kab_kota ";
	
	//echo $query;
					
	$fetchdb = $database->simpleDB_queryinput($query);
	
	return $fetchdb;
}

function getSekolahNoNPSNList($pertanyaan_id)
{
	global $simplePAGE, $database;
	$query = "SELECT MAX(jawaban_id), jawaban_value, b.jwbtouser_id, c.sekolah, e.kabupaten_kota, f.propinsi " .
					"FROM " . $simplePAGE['tableprefix'] . "jawaban AS b, " .
					$simplePAGE['tableprefix'] . "jawabantouser AS c, " .
					$simplePAGE['tableprefix'] . "core_kabupaten_kota AS e, " . 
					$simplePAGE['tableprefix'] . "core_propinsi AS f " .
					"WHERE b.pertanyaan_id = '$pertanyaan_id' AND b.jwbtouser_id = c.jwbtouser_id " .
					"AND c.kode_kab_kota = e.kode_kab_kota " . 
					"AND e.kode_propinsi = f.kode_propinsi " .
					"AND c.jwbtouser_update = '1' " .
					"GROUP BY b.jwbtouser_id " . 
					"ORDER BY f.kode_propinsi, e.kode_kab_kota ";
	
	//echo $query;
					
	$fetchdb = $database->simpleDB_queryinput($query);
	
	return $fetchdb;
}

function getImageList( $pertanyaan_id, $instrumen_sub_type )
{
	global $simplePAGE, $database;
	
	if($instrumen_sub_type == 'sekolah' || $instrumen_sub_type == 'sekolah tanpa npsn' || $instrumen_sub_type == 'sekolah dengan atau tanpa npsn'|| $instrumen_sub_type == 'user sekolah data bulanan' || $instrumen_sub_type == 'user sekolah data bulanan dan jenis kelamin' )
	{
		$query = "SELECT " . 
					"a.jawaban_id, a.jawaban_value, c.sekolah, d.propinsi, e.kabupaten_kota " .
					"FROM " . $simplePAGE['tableprefix'] . "jawaban AS a, " .
					$simplePAGE['tableprefix'] . "jawabantouser AS b, " .
					$simplePAGE['tableprefix'] . "sekolah_data AS c, " .
					$simplePAGE['tableprefix'] . "core_propinsi AS d, " .
					$simplePAGE['tableprefix'] . "core_kabupaten_kota AS e " .
					"WHERE a.pertanyaan_id = '$pertanyaan_id' " . 
					"AND a.jwbtouser_id = b.jwbtouser_id " .
					"AND b.npsn = c.npsn " .
					"AND b.kode_kab_kota = e.kode_kab_kota " . 
					"AND e.kode_propinsi = d.kode_propinsi " . 
					"AND c.kode_prop = d.kode_propinsi " .   
					"AND c.kode_kab_kota = e.kode_kab_kota ";
	}
	elseif($instrumen_sub_type == 'dinas pendidikan' || $instrumen_sub_type == 'user dinas pendidikan data bulanan' )
	{
		$query = "SELECT " . 
					"a.jawaban_id, a.jawaban_value, d.propinsi, e.kabupaten_kota " .
					"FROM " . $simplePAGE['tableprefix'] . "jawaban AS a, " .
					$simplePAGE['tableprefix'] . "jawabantouser AS b, " .
					$simplePAGE['tableprefix'] . "core_propinsi AS d, " .
					$simplePAGE['tableprefix'] . "core_kabupaten_kota AS e " .
					"WHERE a.pertanyaan_id = '$pertanyaan_id' " . 
					"AND a.jwbtouser_id = b.jwbtouser_id " .
					"AND b.kode_kab_kota = e.kode_kab_kota " . 
					"AND e.kode_propinsi = d.kode_propinsi " ;
	}
	
				
	//echo $query;			
	$fetchdb = $database->simpleDB_queryinput($query);
	return $fetchdb;
}

function showChart($data)
{
	global $simplePAGE, $database;
	//print_r($ya);
	//print_r($total);
	for($i=0;$i<count($data);$i++)
	{
		$judul = $data[$i]['pertanyaan'];
		//$yaTampil = $ya[0]['ya'];
		
		$sumDataPoint = 0;

		foreach ($data[$i]['pertanyaan_point'] as $k=>$v) {
			$sumDataPoint += $v;
		}
		
		//$totalTampil = $total[0]['total'];
		//$tidakTampil = $totalTampil - $yaTampil;
		//echo $totalTampil;
		if( ($sumDataPoint != NULL) && ($sumDataPoint != '') && ($sumDataPoint != 0) )
		{
			//echo $totalTampil;
			//$yaPerc = number_format( (( $yaTampil / $totalTampil ) * 100) ,2,".",",");
			//$tidakPerc = number_format( (( $tidakTampil / $totalTampil ) * 100) ,2,".",",");
		
		
		//echo $yaPerc;
		//echo $tidakPerc;
		?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
        	<?php
        	$counterI = 0;
        	foreach($data[$i]['pertanyaan_point'] as $key => $value)
        	{
						?>
						['<?php echo trim($key); ?> (<?php echo trim($value); ?>)', <?php echo trim($value); ?>]
						/*['<?php echo trim($key); ?>', {v: <?php echo trim($value); ?>, f: '<?php echo trim($key); ?> (<?php echo $value; ?>)'}]*/<?php
						
						if($counterI< (count($data[$i]['pertanyaan_point'])-1))
						{
							echo ",";
						}
						//echo count($data[$i]['pertanyaan_point']);
						$counterI++;
						echo "\n";
					}
        	?>
        ]);
				
				screenwidth = 3/4 * window.innerWidth ;
				
				
        // Set chart options
        var options = {'title':'<?php echo htmlspecialchars_decode(str_replace("::comma::",",",$judul)); ?>',
                       'width':screenwidth,
                       'height':600,
											 pieSliceText: 'percentage',
											 tooltip: {
												 showColorCode: true,
												 text: 'value',
												 trigger: 'selection'
											 },
											 'chartArea': {'width': '100%', 'height': '80%'},
											 is3D: true,
											 sliceVisibilityThreshold:0,
											 colors: ['#FD5C31', '#8578D3' ,'#FFEE35', '#59E000', '#EE59FF', '#CC0000', '#51F6FF', '#0700E8', '#FF91DF','#79A500']
											 };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_total<?php echo $i; ?>'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-sm-12 content-bg content-padding">
    	<div id="chart_total<?php echo $i; ?>"></div>
    </div>
    <?php
		}
	}
	
}

function showList($data, $instrumen_sub_type, $pertanyaan_type)
{
	//echo "satu";
	if($instrumen_sub_type == 'sekolah' || $instrumen_sub_type == 'sekolah tanpa npsn' || $instrumen_sub_type == 'sekolah dengan atau tanpa npsn'|| $instrumen_sub_type == 'user sekolah data bulanan' || $instrumen_sub_type == 'user sekolah data bulanan dan jenis kelamin' )
	{
		//echo "dua";
		if($pertanyaan_type == '3' || $pertanyaan_type == '4' )	
		{
			?>
			<thead class="thead-dark">
				<tr>
					<th>
						Sekolah
					</th>
					<th>
						Propinsi
					</th>
					<th>
						Kabupaten / Kota
					</th>
					<th>
						Jawaban
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
			//echo "tiga";
			for($i=0;$i<count($data);$i++)
			{
			?>
				<tr>
					<td>
						<?php echo $data[$i]['sekolah']; ?>
					</td>
					<td>
						<?php echo $data[$i]['propinsi']; ?>
					</td>
					<td>
						<?php echo $data[$i]['kabupaten_kota']; ?>
					</td>
					<td>
						<?php echo $data[$i]['jawaban_value']; ?>
					</td>
				</tr>
			<?php	
			}
			?>
			</tbody>
			<?php
		}
	}
}

function showFotoList($item, $instrumen_sub_type)
{
	//print_r($item);
	
	if($instrumen_sub_type == 'sekolah' || $instrumen_sub_type == 'sekolah tanpa npsn' || $instrumen_sub_type == 'sekolah dengan atau tanpa npsn'|| $instrumen_sub_type == 'user sekolah data bulanan' || $instrumen_sub_type == 'user sekolah data bulanan dan jenis kelamin' )
	{
	?>
	<thead class="thead-dark">
		<tr>
			<th>
				Sekolah
			</th>
			<th>
				Propinsi
			</th>
			<th>
				Kabupaten / Kota
			</th>
			<th>
				Jawaban
			</th>
		</tr>
	</thead>
	<?php
	}
	elseif($instrumen_sub_type == 'dinas pendidikan' || $instrumen_sub_type == 'user dinas pendidikan data bulanan' )
	{
	?>
	<thead class="thead-dark">
		<tr>
			<th>
				Propinsi
			</th>
			<th>
				Kabupaten / Kota
			</th>
			<th>
				Jawaban
			</th>
		</tr>
	</thead>
	<?php
	}
	?>
	<tbody>
	<?php
	for($i=0;$i<count($item);$i++)
	{
	?>
		<tr>
			<?php
			if($instrumen_sub_type == 'sekolah' || $instrumen_sub_type == 'sekolah tanpa npsn' || $instrumen_sub_type == 'sekolah dengan atau tanpa npsn'|| $instrumen_sub_type == 'user sekolah data bulanan' || $instrumen_sub_type == 'user sekolah data bulanan dan jenis kelamin' )
			{
			?>
			<td>
				<?php echo $item[$i]['sekolah']; ?>
			</td>
			<?php
			}
			?>
			<td>
				<?php echo $item[$i]['propinsi']; ?>
			</td>
			<td>
				<?php echo $item[$i]['kabupaten_kota']; ?>
			</td>
			<td>
				<?php echo $item[$i]['jawaban_value']; ?>
			</td>
		</tr>
	<?php	
	}
	?>
	</tbody>
	<?php
}

$qPertanyaan = "SELECT * FROM ".$simplePAGE['tableprefix']."pertanyaan AS a " .
						"WHERE pertanyaan_id = '$pertanyaan_id'";

//echo $queryCheck;

$fPertanyaan = $database->simpleDB_queryinput($qPertanyaan);

$diagramData[0]['pertanyaan_id'] = $pertanyaan_id;
$diagramData[0]['pertanyaan'] = $fPertanyaan[0]['pertanyaan_isi'];

$instrumen_sub_type = getInstrumenType($pertanyaan_id);

if($instrumen_sub_type[0]['instrumen_sub_type'] == 'sekolah' || $instrumen_sub_type[0]['instrumen_sub_type'] == 'user sekolah data bulanan' || $instrumen_sub_type[0]['instrumen_sub_type'] == 'user sekolah data bulanan dan jenis kelamin')
{
	$sekolahList = getSekolahList($pertanyaan_id);	
}
elseif($instrumen_sub_type[0]['instrumen_sub_type'] == 'sekolah tanpa npsn')
{
	$sekolahList = getSekolahNoNPSNList($pertanyaan_id);
}


//echo $fPertanyaan[0]['pertanyaan_type'];

//echo $pertanyaanList[$iPtyn]['pertanyaan_isi'] . "<br />";
if( $fPertanyaan[0]['pertanyaan_type'] == '3' )
{
	$pertanyaanPointList = getPertanyaanPoint($fPertanyaan[0]['pertanyaan_id']);
	
	for($iPpnt=0;$iPpnt<count($pertanyaanPointList);$iPpnt++)
	{
		$getCountJawaban = getCountJawabanPoint($fPertanyaan[0]['pertanyaan_id'], $pertanyaanPointList[$iPpnt]['pertanyaan_point_value']);
		
		//echo $getCountJawaban;
		
		$diagramData[0]['pertanyaan_point'][$pertanyaanPointList[$iPpnt]['pertanyaan_point_value']] = $getCountJawaban;
		//echo $getCountJawaban;
	}
}
elseif( $fPertanyaan[0]['pertanyaan_type'] == '4' )
{
	$pertanyaanPointList = getPertanyaanPoint($fPertanyaan[0]['pertanyaan_id']);
	
	for($iPpnt=0;$iPpnt<count($pertanyaanPointList);$iPpnt++)
	{
		$getCountJawaban = getCountJawabanPoint($fPertanyaan[0]['pertanyaan_id'], $pertanyaanPointList[$iPpnt]['pertanyaan_point_value']);
		
		//echo $getCountJawaban;
		
		$diagramData[0]['pertanyaan_point'][$pertanyaanPointList[$iPpnt]['pertanyaan_point_value']] = $getCountJawaban;
		//echo $getCountJawaban;
	}
}
elseif( $fPertanyaan[0]['pertanyaan_type'] == '10' )
{
	$fotoList = getImageList($fPertanyaan[0]['pertanyaan_id'], $instrumen_sub_type[0]['instrumen_sub_type']);
	//print_r($fotoList);
}

if(count($fPertanyaan) == 0)
{
?>
											<label class="form-control-label">Pilih Pertanyaan</label>
	                  	<select name="ptra_pertanyaan_id" id="ptra_pertanyaan_id" class="form-control">
	                  		<option>--Pertanyaan--</option>
	                  	</select>
<?php
}
else
{
?>
			<div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header d-flex align-items-center">
            	<?php echo str_replace("::comma::",",",$fPertanyaan[0]['pertanyaan_isi']); ?>
            </div>
            <div class="card-body">
            	<?php
            	//print_r($diagramData);
            	if($fPertanyaan[0]['pertanyaan_type'] == '3' || $fPertanyaan[0]['pertanyaan_type'] == '4')
            	{
								showChart($diagramData);	
							}
							elseif( $fPertanyaan[0]['pertanyaan_type'] == '10' )
							{
								//print_r($fotoList);
								showFotoList($fotoList, $instrumen_sub_type[0]['instrumen_sub_type']);
							}
            	?>
            </div>
          </div>
        </div>
      </div>
      
      <?php
      if($fPertanyaan[0]['pertanyaan_type'] == '3' || $fPertanyaan[0]['pertanyaan_type'] == '4')
      {
      ?>
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
            	<table class="table table-striped table-bordered">
            	<?php //echo $instrumen_sub_type[0]['instrumen_sub_type']; ?>
            	<?php
            		//print_r($sekolahList);
								showList($sekolahList, $instrumen_sub_type[0]['instrumen_sub_type'], $fPertanyaan[0]['pertanyaan_type']);	
							?>
            	</table>
            </div>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
<?php

}
?>