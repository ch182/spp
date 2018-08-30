<?php
if(isset($_SESSION['SES_ADMIN'])) {
	echo "<h2>Selamat datang Administrator........!</h2>";
	echo "";
	exit;
}
elseif(isset($_SESSION['SES_PENGAJARAN'])) {
	echo "<h2>Selamat datang Pengajaran........!</h2></p>";
	echo "";
	exit;
}
elseif(isset($_SESSION['SES_KASIR'])) {
	echo "<h2>Selamat datang Kasir........!</h2></p>";
	echo "";
	exit;
}
else {
	echo "<h2>Selamat datang ........!</h2></p>";
	echo "";	
}
?>