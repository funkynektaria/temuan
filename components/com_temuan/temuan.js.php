$( function() {
	$( "#temuan_tanggal" ).datepicker({
	changeMonth: true,
	changeYear: true,
	yearRange: "-1:+0",
	dateFormat: "yy-mm-dd"
	});
} );

$( function() {
$( "#tinjut_tanggal" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "-1:+0",
dateFormat: "yy-mm-dd"
});
} );

function uploadberkastemuan(tid)
{
	var file_data = $('#asr_berkas_temuan').prop('files')[0];
	var form_data = new FormData();
	form_data.append('file', file_data);
	form_data.append('tid', tid);
	//alert(form_data);
	$.ajax({
		url: '<?php echo $simplePAGE['basename']; ?>lib/ajax/simpanberkastemuan.php', // point to server-side PHP script
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		type: 'post',
		success: function(data){
			$('#upload_berkas_status').html(data); // display response from the PHP script, if any
			
			$.ajax({
				type: "post",
				url: "<?php echo $simplePAGE['basename']; ?>lib/ajax/tampilkanberkastemuan.php",
				data: 'tid=' + tid,
				success: function (data) {
					$('#daftar_berkas_temuan').html(data); // display response from the PHP script, if any
				}
			});
		}
	});
}

function uploadberkastinjut(tinid)
{
	var file_data = $('#asr_berkas_tinjut').prop('files')[0];
	var form_data = new FormData();
	form_data.append('file', file_data);
	form_data.append('tinid', tinid);
	//alert(form_data);
	$.ajax({
		url: '<?php echo $simplePAGE['basename']; ?>lib/ajax/simpanberkastinjut.php', // point to server-side PHP script
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		type: 'post',
		success: function(data){
		$('#upload_berkas_status').html(data); // display response from the PHP script, if any

		$.ajax({
			type: "post",
			url: "<?php echo $simplePAGE['basename']; ?>lib/ajax/tampilkanberkastinjut.php",
			data: 'tinid=' + tinid,
			success: function (data) {
			$('#daftar_berkas_temuan').html(data); // display response from the PHP script, if any
			}
		});
		}
	});
}

