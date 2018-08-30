<?php
if(empty($_SESSION['SES_ADMIN'])) {
	echo "<center>";
	echo "<br> <br> <b>Maaf Akses Anda Ditolak!</b> <br>
		  Silahkan masukkan Data Login Anda dengan benar untuk bisa mengakses halaman ini.";
	echo "</center>";
	
	// Mengakses file Login
	if(file_exists("login.php")){ 
		include_once "login.php";
	}
	else {
		// Refresh
		echo "<br> <br> <b>Maaf Akses Anda Ditolak!</b> ";
		echo "<meta http-equiv='refresh' content='0; url=../?'>";
	}
	exit;
}
?>