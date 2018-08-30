<?php
if(empty($_SESSION['SES_ADMIN']) and empty($_SESSION['SES_PENGAJARAN']) and empty($_SESSION['SES_KASIR'])) {
	echo "<center>";
	echo "<br> <br> <b>Maaf Akses Anda Ditolak !</b> <br>
		  Anda harus login sebagai Admin atau Petugas (Pengajaran / Kasir). Silahkan masukkan Data Login Anda dengan benar untuk bisa mengakses halaman ini.";
	echo "</center>";
	
	// Mengakses file Login
	if(file_exists("login.php")){ 
		include_once "login.php";
	}
	else {
		// Refresh
		echo "<meta http-equiv='refresh' content='0; url=../?'>";
	}
	exit;
}
?>