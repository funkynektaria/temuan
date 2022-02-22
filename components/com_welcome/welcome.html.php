<?php

class com_welcome_html
{
	
	//configuration vars
	var $simplePAGE = array();
	
	//database object
	var $database;
	
	function __construct( $database, $simplePAGE )
	{
		$this->simplePAGE = $simplePAGE;
		$this->database = $database;
	}
	
	function showWelcomeMessage()
	{
		?>
		<div class="row">
		  <div class="col-sm-12 text-center">
		    <h3>Selamat Datang di Aplikasi <?php echo $this->simplePAGE['title']; ?></h3>
		  </div>
		</div>
		<?php
	}
	
	function showDataList( $item )
	{
		$com_welcome = new com_welcome( $this->database , $this->simplePAGE );
		
		?>
		<div class="card">
			<div class="card-body">
				<div class="row mt-20">
					<div class="col-sm-12 table-header table-header-bg text-center">Laporan yang telah diinput</div>
				</div>
				<div class="row">
					<div class="col-sm-2 table-header table-header-bg">Tanggal Pekerjaan</div>
					<div class="col-sm-5 table-header table-header-bg">Uraian Pekerjaan</div>
					<div class="col-sm-2 table-header table-header-bg">Pelaksana Tugas</div>
					<div class="col-sm-1 table-header table-header-bg">Status</div>
					<div class="col-sm-1 table-header table-header-bg">Berkas</div>
					<div class="col-sm-1 table-header table-header-bg">&nbsp;</div>	
				</div>
				<?php
				
				if($item != 0)
				{
					for($i=0;$i<count($item);$i++)
					{
						$fontColor = '';
						//$instrumen_sub_name = $com_welcome->getInstrumenSubName($item[$i]["instrumen_sub_id"]);
						if($item[$i]["edit_status"] == "telah diganti")
						{
							$fontColor = "font-laporan-diganti";
						}
						echo '<div class="row table-row-border  mt-10 '.$fontColor.'">';
							echo '<div class="col-sm-2 table-data">';
							echo $item[$i]['tanggal_pekerjaan'];
							echo '</div>';
							echo '<div class="col-sm-5 table-data">';
							echo $item[$i]["uraian_pekerjaan"];
							echo '</div>';
							echo '<div class="col-sm-2 table-data">';
							echo $item[$i]["pelaksana_tugas"];
							echo '</div>';
							echo '<div class="col-sm-1 table-data">';
							if($item[$i]["status"] == "Selesai")
							{
								echo '<span class="data-selesai '.$fontColor.'">';
							}
							else
							{
								echo '<span class="data-tidak-selesai '.$fontColor.'">';
							}
							echo $item[$i]["status"];
							echo '</div>';
							echo '<div class="col-sm-1 table-data">';
							if(!empty($item[$i]["berkas"]) && $item[$i]["berkas"] != '')
							{
								echo '<a href="openfile.php?file=' . $item[$i]["berkas"] . '">';
								echo '<i class="far fa-file '.$fontColor.'"></i>';	
								echo '</a>';
							}
							//echo $item[$i]["berkas"];
							echo '</div>';
							echo '<div class="col-sm-1 table-data">';
							if($item[$i]["edit_status"] == "telah diganti")
							{
								echo "laporan telah di edit";
							}
							else
							{
								echo '<a href="'.$this->simplePAGE['basename'].'index.php?act=site&mode=com_laporanedit&amode=edit&lid='.$item[$i]["laporan_id"].'" class="btn btn-warning">Edit</a>';
							}
							
							echo '</div>';
						echo '</div>';
					}
				}
				else
				{
					?>
					<div class="row">
						<div class="col-sm-12 text-center">Data tidak tersedia</div>
					</div>
					<?php
				}
				?>	
							
			</div>
		</div>
		<?php
	}
	
	function showPost($item)
	{
		?>
		<div class="card">
			<div class="card-body">
				<div class="row row-content">
		    	<div class="col-sm-12">
		    		<?php
		    			for($i=0;$i<count($item);$i++)
		    			{
		    				?>
		    				<div class='row'>
		    					<div class="col-sm-12">
		    						<h3>
		    						<?php echo $item[$i]['post_title']; ?>
		    						</h3>
		    					</div>
		    				</div>
		    				<div class='row'>
		    					<div class="col-sm-12">
		    						<span class='info-date'>
		    						<?php echo $item[$i]['post_insert_date']; ?>
		    						</span>
		    					</div>
		    				</div>
		    				<div class='row info-content'>
		    					<div class="col-sm-12">
		    						<?php echo $item[$i]['post_content']; ?>
		    					</div>
		    				</div>
		    				<?php
							}
		    		?>
		    	</div>
		    </div>
    	</div>
		</div>
		<?php
	}
	
	function showDownload($item)
	{
		//print_r($item);
		?>
		<div class="card mt-20">
			<div class="card-header">
				<div class="row">
					<div class="col-sm-12">
						<h4>File untuk di Download</h4>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
		    	<div class="col-sm-12">
		    		<ul class="download-item">
		    		<?php
		    			for($i=0;$i<count($item);$i++)
		    			{
		    				?>
		    				<li><a href="downloadfiles/<?php echo $item[$i]['ftd_url']; ?>"><?php echo $item[$i]['ftd_name']; ?></a></li>
		    				<?php
							}
		    		?>
		    		</ul>
		    	</div>
		    </div>
    	</div>
		</div>
		<?php
	}
	
	function showUserPaging( $userCount )
	{
		$count = $userCount / 30 ;
		$ceilCount = ceil($count);
		if($ceilCount > 1)
		{
			if(isset($_GET['limit'])) $limitNow = $_GET['limit'];
			else $limitNow = 1;
			
			echo '<div class="row mt-20">';
			echo '<div class="offset-sm-2 col-sm-8 text-right">';
			
			if( $limitNow != $ceilCount )
			{
				echo "<span class=\"page-limit-number\"><a href=\"" . $this->simplePAGE['basename'] . 
					"index.php?act=site&mode=com_welcome&limit=" . ($limitNow + 1) . "\">Next</a></span>\n";
			}
			
			for($i=1;$i<=$ceilCount;$i++)
			{
				if($i!=$limitNow)
				{
					echo "<span class=\"page-limit-number\"><a href=\"" . $this->simplePAGE['basename'] . 
					"index.php?act=site&mode=com_welcome&limit=". $i . "\">$i</a></span> \n";
				}
				else
				{
					echo "<span class=\"page-limit-number-selected\">$i</span>\n";
				}
			}
			echo "</div>";
			echo "</div>";
		}
	}
	
}


?>