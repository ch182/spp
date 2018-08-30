<?php
include_once "library/inc.ses_admin.php";

// Kode di URL harus ada
if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Membaca Kode dari URL
	$Kode	= $_GET['Kode'];
	
	// Menghapus data sesuai Kode yang didapat di URL
	// Hapus data User, Kecuali yang username-nya admin tidak boleh dihapus
	$mySql 	= "DELETE FROM user WHERE kode_user='$Kode' AND username !='admin'";
	$myQry 	= mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	if($myQry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=User-Data'>";
	}
}
?>