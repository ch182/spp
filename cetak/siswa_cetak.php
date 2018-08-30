<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

date_default_timezone_set("Asia/Jakarta");

if($_GET) {
	$Kode	= $_GET['Kode'];
	$mySql	= "SELECT siswa.*, jurusan.nama_jurusan FROM siswa 
				LEFT JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan 
				WHERE siswa.kode_siswa='$Kode'";
	$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
	$myData	= mysql_fetch_array($myQry);
	
	// Status foto
	if($myData['foto'] =="") {
		$namaFoto	= "images.jpg";
	}
	else {
		$namaFoto	= $myData['foto'];
	}
}
?>
<html>
<head>
<title>:: Cetak Data Siswa</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="window.print()">
<h1>DATA SISWA </h1>
  <table width="800" border="0" cellpadding="3" cellspacing="1">
    
    <tr>
      <td width="199"><b>Kode</b></td>
      <td width="10"><b>:</b></td>
      <td width="521"><?php echo $myData['kode_siswa']; ?></td>
    </tr>
    <tr>
      <td><b>NIS </b></td>
      <td><b>:</b></td>
      <td> <?php echo $myData['nis']; ?>  </td>
    </tr>
    <tr>
      <td><b>Nama Siswa </b></td>
      <td><b>:</b></td>
      <td> <?php echo $myData['nama_siswa']; ?> </td>
    </tr>
    <tr>
      <td><b>Jenis Kelamin </b></td>
      <td><b>:</b></td>
      <td><?php echo $myData['kelamin']; ?></td>
    </tr>
    <tr>
      <td><b>Agama</b></td>
      <td><b>:</b></td>
      <td><?php echo $myData['agama']; ?></td>
    </tr>
    <tr>
      <td><b>Alamat Lengkap </b></td>
      <td><b>:</b></td>
      <td><?php echo $myData['alamat']; ?></td>
    </tr>
    <tr>
      <td><b>No. Telepon</b></td>
      <td><b>:</b></td>
      <td><?php echo $myData['no_telepon']; ?></td>
    </tr>
    <tr>
      <td><b>Jurusan </b></td>
      <td><b>:</b></td>
      <td><?php echo $myData['nama_jurusan']; ?></td>
    </tr>
    <tr>
      <td><b>Angkatan </b></td>
      <td><b>:</b></td>
      <td><?php echo $myData['th_angkatan']; ?></td>
    </tr>
    <tr>
      <td><b>Status</b></td>
      <td><b>:</b></td>
      <td><?php echo $myData['status']; ?></td>
    </tr>
</table>
  <img src="../foto/siswa/<?php echo $namaFoto; ?>" width="100" height="125">
</body>
</html>
