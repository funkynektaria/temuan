<?php

class com_sys_html
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
	
	function showHeader()
	{
		?>
		<div class="card">
			<div class="card-header">
				<h3>Temuan</h3>
			</div>
		</div>
		<?php
	}
	
	function showRedirect($mode, $amode, $vars)
	{
		?>
		<script>
		window.location.href = "<?php echo $this->simplePAGE['basename'] . 'index.php?act=site&mode=' . $mode . '&amode=' . $amode . $vars; ?>";
		</script>
		<?php
	}
	
	function showRedirectHome($mode)
	{
	?>
	<script>
	window.location.href = "<?php echo $this->simplePAGE['basename'] . 'index.php?act=site&mode=' . $mode; ?>";
	</script>
	<?php
}
	
	function showTambahTemuan()
	{
	?>
	<div class="card">
		<div class="card-body">
			<a href="<?php echo $this->simplePAGE['basename']; ?>index.php?act=site&mode=com_temuan&amode=tambahtemuan" class="btn btn-lg btn-warning">Tambah Temuan</a>
		</div>
	</div>
	<?php
	}
	
	function showFormTambahTemuan($penemu)
	{
	?>
	<div class="card">
		<div class="card-body">
			<form action="<?php echo $this->simplePAGE['basename']; ?>index.php?act=site&mode=<?php echo $_GET['mode']; ?>&amode=recordtemuan" method="post">
				<div class="form-group">
					<label for="temuan_nama">Nama Temuan:</label>
					<input type="text" class="form-control" name="temuan_nama" placeholder="Nama Temuan" id="temuan_nama">
				</div>
				<div class="form-group">
					<label for="temuan_tanggal">Tanggal Temuan:</label>
					<input type="text" class="form-control datepicker" name="temuan_tanggal" placeholder="Tanggal Temuan" id="temuan_tanggal">
				</div>
				<div class="form-group">
					<label for="temuan_deskripsi">Deskripsi Temuan: </label>
					<textarea rows="5" " class="form-control" name="temuan_deskripsi" id="temuan_deskripsi"></textarea>
				</div>
				<div class="form-group">
					<label for="temuan_tanggal">Ditemukan oleh:</label>
					<select class="form-control" name="temuan_oleh" id="temuan_oleh">
						<?php
						if (is_iterable($penemu))
						{
							for ($iPen=0;$iPen<count($penemu);$iPen++)
							{
								echo '<option value="'.$penemu[$iPen]['temuanoleh_id'].'">'.$penemu[$iPen]['temuanoleh_nama'].'</option>';
							}
						}
						
						?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form> 
		</div>
	</div>
	<?php
	}
	
	function showFormEditTemuan($penemu, $item)
	{
	?>
	<div class="card">
		<div class="card-body">
			<form action="<?php echo $this->simplePAGE['basename']; ?>index.php?act=site&mode=<?php echo $_GET['mode']; ?>&amode=recordedittemuan" method="post">
				<div class="form-group">
					<label for="temuan_nama">Nama Temuan:</label>
					<input type="text" class="form-control" name="temuan_nama" placeholder="Nama Temuan" id="temuan_nama" value="<?php echo $item[0]['temuan_nama']; ?>">
				</div>
				<div class="form-group">
					<label for="temuan_tanggal">Tanggal Temuan:</label>
					<input type="text" class="form-control datepicker" name="temuan_tanggal" placeholder="Tanggal Temuan" id="temuan_tanggal" value="<?php echo $item[0]['temuan_tanggal']; ?>">
				</div>
				<div class="form-group">
					<label for="temuan_deskripsi">Deskripsi Temuan: </label>
					<textarea rows="5" class="form-control" name="temuan_deskripsi" id="temuan_deskripsi"><?php echo $item[0]['temuan_deskripsi']; ?></textarea>
				</div>
				<div class="form-group">
					<label for="temuan_tanggal">Ditemukan oleh:</label>
					<select class="form-control" name="temuan_oleh" id="temuan_oleh">
						<?php
	if (is_iterable($penemu)) 
	{
		for ($iPen=0;$iPen<count($penemu);$iPen++) 
		{
			if ($penemu[$iPen]['temuanoleh_id'] == $item[0]['temuanoleh_id']) 
			{
				echo '<option value="'.$penemu[$iPen]['temuanoleh_id'].'" selected>'.$penemu[$iPen]['temuanoleh_nama'].'</option>';
			}
			else
			{
				echo '<option value="'.$penemu[$iPen]['temuanoleh_id'].'">'.$penemu[$iPen]['temuanoleh_nama'].'</option>';
			}
		}
	}

	?>
					</select>
				</div>
				<input type="hidden" id="temuan_id" name="temuan_id" value="<?php echo $item[0]['temuan_id']; ?>">
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
	<?php
}
	
	function showTemuanDetail($item)
	{
		?>
		<div class="card">
			<div class="card-body">
				<div class="row mb-2 border-bottom">
					<div class="col-3">
						<h5>Judul Temuan</h5>
					</div>
					<div class="col">
						<h5><?php echo $item[0]['temuan_nama']; ?></h5>
					</div>
				</div>
				<div class="row mb-2 border-bottom">
					<div class="col-3">
						Tanggal Temuan
					</div>
					<div class="col">
						<?php echo $item[0]['temuan_tanggal']; ?>
					</div>
				</div>
				<div class="row mb-2 border-bottom">
					<div class="col-3">
						Deskripsi Temuan
					</div>
					<div class="col">
						<?php echo $item[0]['temuan_deskripsi']; ?>
					</div>
				</div>
				<div class="row mb-2 border-bottom">
					<div class="col-3">
						Ditemukan Oleh
					</div>
					<div class="col">
						<?php echo $item[0]['temuanoleh_nama']; ?>
					</div>
				</div>
				
			</div>
		</div>
		<?php
	}
	
	function showTinjutDetail($tinjut, $item)
	{
	?>
	<div class="card">
		<div class="card-body">
			<div class="row mb-2 border-bottom">
				<div class="col-3">
					<h5>Judul Temuan</h5>
				</div>
				<div class="col">
					<h5><?php echo $item[0]['temuan_nama']; ?></h5>
				</div>
			</div>
			<div class="row mb-2 border-bottom">
				<div class="col-3">
					Rincian Tindak Lanjut
				</div>
				<div class="col">
					<?php echo $tinjut[0]['tinjut_rincian']; ?>
				</div>
			</div>
			<div class="row mb-2 border-bottom">
				<div class="col-3">
					Tanggal Tindak Lanjut
				</div>
				<div class="col">
					<?php echo $tinjut[0]['tinjut_tanggal']; ?>
				</div>
			</div>
			<div class="row mb-2 border-bottom">
				<div class="col-3">
					Petugas yang ditugaskan untuk Tindak Lanjut
				</div>
				<div class="col">
					<?php echo $tinjut[0]['tinjut_petugas']; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
	
	function showTemuanBerkasAdd()
	{
		?>
		<div class="card">
			<div class="card-body">
				<div class="form-group">
					<label>Berkas Temuan:</label>
					<input type="file" class="form-control" id="asr_berkas_temuan" onchange="uploadberkastemuan(<?php echo $_GET['tid']; ?>)">
				</div>
				<div id="upload_berkas_status"></div>
			</div>
		</div>
		<?php
	}
	
	function showTinjutBerkasAdd()
	{
	?>
	<div class="card">
		<div class="card-body">
			<div class="form-group">
				<label>Berkas Tindak Lanjut:</label>
				<input type="file" class="form-control" id="asr_berkas_tinjut" onchange="uploadberkastinjut(<?php echo $_GET['tinid']; ?>)">
			</div>
			<div id="upload_berkas_status"></div>
		</div>
	</div>
	<?php
}
	
	function showDaftarTemuanBerkas($item, $temuan_detail)
	{
		?>
		<div class="card">
			<div class="card-header">
				Daftar Berkas Temuan
			</div>
			<div class="card-body">
				<div id="daftar_berkas_temuan">
				<?php 
				if (is_iterable($item))
				{
					for ($iTem=0;$iTem<count($item);$iTem++)
					{
						
						$file_ext = substr(strrchr($item[$iTem]['temuandokumen_loc'],'.'),1);
						
						echo '<div class="row mt-1">';
						echo '<div class="col-sm-3">';
						echo '<small>';
						echo '<a href="openfile.php?file='.$item[$iTem]['temuandokumen_loc'].'&rename=TEMUAN_'.str_replace(' ', '_', $temuan_detail[0]['temuan_nama']).'_'.($iTem+1).'.'.$file_ext.'" target="_blank">';
						echo $item[$iTem]['temuandokumen_loc'];
						echo '</a>';
						echo '</small>';
						echo '</div>';
						echo '<div class="col-sm-4">';
						echo ' <a href="'. $this->simplePAGE['basename'] . 'index.php?act=site&mode=' .$_GET['mode'] .'&amode=temuanberkasdelete&tembid='.$item[$iTem]['temuandokumen_id'].'&tid='.$temuan_detail[0]['temuan_id'].'" class="btn btn-sm btn-danger">';
						echo '<i class="fas fa-trash-alt"></i>';
						echo '</a>';
						echo '</div>';
						echo '</div>';
					}
				}
				
				?>
				</div>
			</div>
		</div>
		<?php
	}
	
	function showDaftarTinjutBerkas($item)
	{
	?>
	<div class="card">
		<div class="card-header">
			Daftar Berkas Tindak Lanjut
		</div>
		<div class="card-body">
			<div id="daftar_berkas_temuan">
				<?php
				if (is_iterable($item)) {
					for ($iTem=0;$iTem<count($item);$iTem++) {

						echo '<div class="row">';
						echo '<div class="col">';
						echo '<small>';
						echo $item[$iTem]['tinjutdokumen_loc'];
						echo '</small>';
						echo '</div>';
						echo '</div>';
					}
				}

				?>
			</div>
		</div>
	</div>
	<?php
}
	
	function showTemuanTindakLanjutAdd($temuan_id, $temuan_detail)
	{
	?>
	<div class="card">
		
		<div class="card-body">
			<div class="row">
				<div class="col">
					<div class="form-group">
						<label>Rincian Tindak Lanjut:</label>
						<textarea id="tinjut_rincian"></textarea>
					</div>
				</div>
				<div class="col">
					<div class="form-group">
						<label>Staff yang menindak lanjuti:</label>
						<textarea id="tinjut_staff"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="form-group">
						<label>Tanggal Tindak Lanjut:</label>
						<textarea id="tinjut_rincian"></textarea>
					</div>
				</div>
				<div class="col">
					<div class="form-group">
						<label>Berkas Tindak Lanjut:</label>
						<textarea id="tinjut_staff"></textarea>
					</div>
				</div>
			</div>
			<div id="upload_berkas_status"></div>
		</div>
	</div>
	<?php
	}
	
	function showFormTambahTinjut($temuan_id, $temuan_detail)
	{
	?>
	<div class="card">
		<div class="card-header">
			<?php echo $temuan_detail[0]['temuan_nama']; ?>
		</div>
		<div class="card-body">
			<form action="<?php echo $this->simplePAGE['basename']; ?>index.php?act=site&mode=<?php echo $_GET['mode']; ?>&amode=recordtinjut" method="post">
				<div class="form-group">
					<label for="temuan_nama">Rincian Tindak Lanjut:</label>
					<textarea class="form-control" name="tinjut_rincian" placeholder="Rincian Tindak Lanjut" id="tinjut_rincian"></textarea>
				</div>
				<div class="form-group">
					<label for="temuan_tanggal">Tanggal Tindak Lanjut:</label>
					<input type="text" class="form-control datepicker" name="tinjut_tanggal" placeholder="Tanggal Tindak Lanjut" id="tinjut_tanggal">
				</div>
				<div class="form-group">
					<label for="temuan_tanggal">Petugas Yang Menangani Tindak Lanjut:</label>
					<input type="text" class="form-control" name="tinjut_petugas" placeholder="Petugas Yang Menangani Tindak Lanjut" id="tinjut_petugas">
				</div>
				<input type="hidden" name="tid" value="<?php echo $temuan_id; ?>">
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
	<?php
}

function showFormEditTinjut($temuan_id, $temuan_detail, $tinjut_detail)
	{
	?>
	<div class="card">
		<div class="card-header">
			<?php echo $temuan_detail[0]['temuan_nama']; ?>
		</div>
		<div class="card-body">
			<form action="<?php echo $this->simplePAGE['basename']; ?>index.php?act=site&mode=<?php echo $_GET['mode']; ?>&amode=updatetinjut" method="post">
				<div class="form-group">
					<label for="temuan_nama">Rincian Tindak Lanjut:</label>
 					<textarea class="form-control" name="tinjut_rincian" placeholder="Rincian Tindak Lanjut" id="tinjut_rincian"><?php echo $tinjut_detail[0]['tinjut_rincian']; ?></textarea>
				</div>
				<div class="form-group">
					<label for="temuan_tanggal">Tanggal Tindak Lanjut:</label>
					<input type="text" class="form-control datepicker" name="tinjut_tanggal" placeholder="Tanggal Tindak Lanjut" id="tinjut_tanggal" value="<?php echo $tinjut_detail[0]['tinjut_tanggal']; ?>">
				</div>
				<div class="form-group">
					<label for="temuan_tanggal">Petugas Yang Menangani Tindak Lanjut:</label>
					<input type="text" class="form-control" name="tinjut_petugas" placeholder="Petugas Yang Menangani Tindak Lanjut" id="tinjut_petugas" value="<?php echo $tinjut_detail[0]['tinjut_petugas']; ?>">
				</div>
				<input type="hidden" name="tid" value="<?php echo $temuan_id; ?>">
				<input type="hidden" name="tinid" value="<?php echo $tinjut_detail[0]['tinjut_id']; ?>">
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
	<?php
	}
	
	function redirect()
	{
		?>
		<script>
		window.location.href = "<?php echo $this->simplePAGE['basename']; ?>";
		</script>
		<?php
	}
	
	function showDaftarTindakLanjut($item, $temuan_id)
	{
		$com_sys =  new com_sys( $this->database , $this->simplePAGE );
		$temuan_detail = $com_sys->getTemuanDetail($_GET['tid']);
		?>
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col">
						Tindak Lanjut Yang Telah Dilakukan
					</div>
				
				
				<?php
				if ($_SESSION['groupid'] == '1') {
				?>
					<div class="col text-right">
						<a href="<?php echo $this->simplePAGE['basename']; ?>index.php?act=site&mode=<?php echo $_GET['mode']; ?>&amode=tambahtinjut&tid=<?php echo $temuan_id; ?>" class="btn btn-warning">Tambahkan Tindak Lanjut</a>
					</div>
				<?php
			}
				?>
				</div>
			</div>
			<div class="card-body">
				<div class="row mb-3 border-bottom">
					<div class="col">
						<strong>Tindak Lanjut</strong>
					</div>
					<div class="col">
						<strong>Petugas</strong>
					</div>
					<div class="col">
						<strong>Tanggal Tindak Lanjut</strong>
					</div>
					<?php
					if ($_SESSION['groupid'] == '1') 
					{
						echo '<div class="col small">';

						echo '</div>';
					}
					?>
				</div>
				<?php
				if(is_iterable($item))
				{
					for($iTinjut=0;$iTinjut<count($item);$iTinjut++)
					{
						?>
						<div class="row mb-3 border-bottom">
							<div class="col">
								<div class="row">
									<div class="col small">
										<?php echo $item[$iTinjut]['tinjut_rincian']; ?>
									</div>
									<div class="col small">
										<?php echo $item[$iTinjut]['tinjut_petugas']; ?>
									</div>
									<div class="col small">
										<?php echo $item[$iTinjut]['tinjut_tanggal']; ?>
									</div>
									<?php
									if ($_SESSION['groupid'] == '1') 
									{
										echo '<div class="col small">';
										echo '<a href="'. $this->simplePAGE['basename']; ?>index.php?act=site&mode=<?php echo $_GET['mode'] .'&amode=tinjuedit&tid='.$temuan_detail[0]['temuan_id'].'&tinid='.$item[$iTinjut]['tinjut_id'].'" class="btn btn-sm btn-warning">';
										echo '<i class="fas fa-edit"></i>';
										echo '</a>';
										echo ' <a href="'. $this->simplePAGE['basename']; ?>index.php?act=site&mode=<?php echo $_GET['mode'] .'&amode=tinjutdelete&tid='.$temuan_detail[0]['temuan_id'].'&tinid='.$item[$iTinjut]['tinjut_id'].'" class="btn btn-sm btn-danger">';
										echo '<i class="fas fa-trash-alt"></i>';
										echo '</a>';
										echo "</div>";

									}
								?>
								</div>
								<div class="row mt-2">
									<div class="col">
									<?php
									
									$BerkasTindakLanjut = $com_sys->getDaftarTinjutBerkas($item[$iTinjut]['tinjut_id']);
									
									if (is_iterable($BerkasTindakLanjut))
									{
										for ($iTj=0;$iTj<count($BerkasTindakLanjut);$iTj++)
										{
											$file_ext = substr(strrchr($BerkasTindakLanjut[$iTj]['tinjutdokumen_loc'],'.'),1);
											?>
											<div class="row">
												<div class="col small">
												<?php
												echo '<a href="openfile.php?file='.$BerkasTindakLanjut[$iTj]['tinjutdokumen_loc'].'&rename=TEMUAN_'.str_replace(' ', '_', $temuan_detail[0]['temuan_nama']).'_'.($iTj+1).'.'.$file_ext.'" target="_blank">';
												echo $BerkasTindakLanjut[$iTj]['tinjutdokumen_loc'];
												echo '</a>';
												?>
											
												</div>
											</div>
											<?php
										}
									}
									?>
									</div>
								</div>	
							</div>
						</div>
						<?php
					}
				}
				
				?>
			</div>
		</div>
		<?php	
	}
	
	function showTemuanList( $item )
	{
		?>
		<div class="card">
			<div class="card-header">
				Daftar Temuan
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col table-responsive">
						<table class="table table-striped">
						<?php
						if (is_iterable($item))
						{
							for ($i=0;$i<count($item);$i++) {
								echo "<tr>";
								echo "<td>";
								echo $item[$i]['temuan_nama'];
								echo "</td>";
								echo "<td>";
								echo $item[$i]['temuanoleh_nama'];
								echo "</td>";
								echo "<td>";
								echo $item[$i]['temuan_tanggal'];
								echo "</td>";
								echo "<td>";
								echo '<a href="'. $this->simplePAGE['basename']; ?>index.php?act=site&mode=<?php echo $_GET['mode'] .'&amode=temuandetail&tid='.$item[$i]['temuan_id'].'" class="btn btn-sm btn-primary">';
								echo 'detail';
								echo '</a>';
								echo "</td>";
								if ($_SESSION['groupid'] == '1') {
									echo '<td>';
									echo '<a href="'. $this->simplePAGE['basename']; ?>index.php?act=site&mode=<?php echo $_GET['mode'] .'&amode=temuanedit&tid='.$item[$i]['temuan_id'].'" class="btn btn-sm btn-warning">';
									echo '<i class="fas fa-edit"></i>';
									echo '</a>';
									echo ' <a href="'. $this->simplePAGE['basename']; ?>index.php?act=site&mode=<?php echo $_GET['mode'] .'&amode=temuandelete&tid='.$item[$i]['temuan_id'].'" class="btn btn-sm btn-danger">';
									echo '<i class="fas fa-trash-alt"></i>';
									echo '</a>';
									echo "</td>";
									
								}
								echo "</tr>";
							}
						}
						
						?>
						</table>
					</div>
				</div>
				
			</div>
		</div>
		<?php
	}
}


?>