<?php
include_once "library/inc.ses_pengajaran.php";

// Kode di URL harus ada
if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Membaca Kode dari URL
	$Kode	= $_GET['Kode'];

	# MENGHAPUS GAMBAR/FOTO, Caranya dengan membaca file gambar
	$mySql = "SELECT * FROM guru WHERE kode_guru='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
	if(! $myData['foto']=="") {
		if(file_exists("foto/guru/".$myData['foto'])) {
			// Jika file gambarnya ada, akan dihapus
			unlink("foto/guru/".$myData['foto']); 
		}
	}
	
	// Menghapus data sesuai Kode yang didapat di URL
	$my2Sql = "DELETE FROM guru WHERE kode_guru='$Kode'";
	$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Eror hapus data".mysql_error());
	if($my2Qry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Guru-Data'>";
	}
}
?>