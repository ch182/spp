<?php
include_once "library/inc.ses_kasir.php";

// Kode di URL harus ada
if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Membaca Kode dari URL
	$Kode	= $_GET['Kode'];
	
	// Menghapus data sesuai Kode yang didapat di URL
	$mySql	= "DELETE FROM pembayaran_dks WHERE no_bayar_dks='$Kode'";
	$myQry	= mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	if($myQry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Pembayaran-DKS-Data'>";
	}
}
?>