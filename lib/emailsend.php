<?php
//echo "terpanggil";

function emailSend ($to, $subject, $message, $mailuser, $mailpass, $mailname, $mailhost )
{
		require_once("../lib/phpmailer2/PHPMailerAutoload.php");
		
		$sendBCC = 'info@bandunggreatrun.com';
				
		$headers = "From: ".$mailuser."" . " \r\n" .
		//"Cc: " . $addCC . " \r\n" .
    "Reply-To: ".$mailuser."" . " \r\n" .
		"Return-Path: ".$mailuser." \r\n" .
		"Content-type: text/html; charset=iso-8859-1" . " \r\n" .
    'X-Mailer: PHP/' . phpversion();
		//$mail_sent = @mail($to, $subject, $message, $headers);
		//echo $mail_sent ? "Terkirim" : "Gagal";
		
		$mail = new PHPMailer();
		// setting
		$mail->IsSMTP();  // Fungsi Pengiriman dengan SMTP
		$mail->Host     = $mailhost; // server mail anda
		$mail->SMTPAuth = true;     
		$mail->Username = $mailuser;  // username email anda
		$mail->Password = $mailpass; //
		
		// pengirim
		$mail->From     = $mail->Username; // Masukan dari form.php variabel email
		$mail->FromName = $mailname; // Masukan dari form.php variabel nama
			
		//echo $sendTo . $_POST['Msubject'];
		
		$mail->AddAddress($to);
		$mail->AddAddress($sendBCC);
		
		$mail->AddReplyTo($mail->Username, $mailname);
		
		//echo $fetchGetEmail[0]['sendTo'];
		
		//$mail->AddCC("$_POST[email]",",$_POST[nama]"); // Jika email akan dikirimkan juga ke pengirim --&gt; masukan dari form : CC
		if(isset($sendBCC))
			$mail->AddBCC($sendBCC); // alamat email BCC
		
		// kirim balik
		
		$mail->WordWrap = 50;                              // set word wrap
		//$mail->AddAttachment(getcwd() . "/$_POST[file1]");      // attachment --&gt; hapus double slash untuk mengaktifkan
		$mail->IsHTML(true);                               // send as HTML
		
		//Subject dan isi Pesan
		$mail->Subject  =  $subject;
		$mail->Body     =  $message;
		$mail->AltBody  =  $message;
		//echo $fetchGetEmail[0]['subject'];
		//echo $fetchGetEmail[0]['message'];
		//echo "masuk";
		if(!$mail->Send())
		{
		 	//echo "<p>Message was not sent </p><p>";
		 	return 0;
		} 
		else
		{
			return 1;
		}
}
    ?>