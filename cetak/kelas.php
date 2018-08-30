<?php
session_start();
include_once "../library/inc.ses_admin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Membaca Kode Tahun Ajaran dari URL
$tahun		= isset($_GET['tahun']) ?  $_GET['tahun'] : '';

if(isset($tahun)) {
	$filterSql	= "WHERE kelas.tahun_ajar = '$tahun' ";
}
else {
	$filterSql = "";
}
?>
<html>
<head>
<title>:: Laporan Data Kelas </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN DATA KELAS </h2>
<table class="table-list" width="800" border="0" cellpadding="2" cellspacing="1">
  <tr>
    <td bgcolor="#F5F5F5"><b>KETERANGAN </b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="158"><b>Tahun Ajaran</b></td>
    <td width="13"><b>:</b></td>
    <td width="613"><?php echo $tahun; ?></td>
  </tr>
</table>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="49" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="118" bgcolor="#F5F5F5"><strong>Tahun Ajaran </strong></td>
    <td width="226" bgcolor="#F5F5F5"><strong>Nama Kelas </strong></td>
    <td width="99" align="left" bgcolor="#F5F5F5"><strong>Qty  Siswa </strong></td>
    <td width="254" bgcolor="#F5F5F5"><strong>Wali Kelas </strong></td>
  </tr>
  <?php
  	// Skrip menampilkan data Kelas
	$mySql = "SELECT kelas.*, guru.nama_guru  FROM kelas 
			  	LEFT JOIN guru ON kelas.kode_guru = guru.kode_guru
				$filterSql
				ORDER BY kelas.tahun_ajar, kelas.kode_kelas ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kode_kelas'];
		
		// Menghitung jumlah Siswa yang ada di setiap Kelas
		$my2Sql = "SELECT COUNT(*) AS total_siswa FROM kelas_siswa WHERE kode_kelas='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kode_kelas']; ?></td>
    <td><?php echo $myData['tahun_ajar']; ?></td>
    <td><?php echo $myData['kelas']." | ".$myData['nama_kelas']; ?></td>
    <td><?php echo $my2Data['total_siswa']; ?></td>
    <td><?php echo $myData['nama_guru']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>