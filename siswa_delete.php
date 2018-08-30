<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

// Kode di URL harus ada
if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Membaca Kode dari URL
	$Kode	= $_GET['Kode'];

	# MENGHAPUS GAMBAR/FOTO, Caranya dengan membaca file gambar
	$mySql = "SELECT * FROM siswa WHERE kode_siswa='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
	if(! $myData['foto']=="") {
		if(file_exists("foto/siswa/".$myData['foto'])) {
			// Jika file gambarnya ada, akan dihapus
			unlink("foto/siswa/".$myData['foto']); 
		}
	}
	
	// Menghapus data sesuai Kode yang didapat di URL
	$my2Sql = "DELETE FROM siswa WHERE kode_siswa='$Kode'";
	$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Eror hapus data".mysql_error());
	if($my2Qry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Siswa-Data'>";
	}
}
?>