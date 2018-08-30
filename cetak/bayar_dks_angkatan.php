<?php
session_start();
include_once "../library/inc.ses_pengajaran.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# FILTER PEMBELIAN PER BULAN/TAHUN
$dataTahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : ''; // Baca dari URL, jika tidak ada diisi tahun sekarang

# Membuat Filter Bulan
if($dataTahun) {
	// Membuat SQL Filter Data per Tahun Angkatan Siswa
	$filterSQL = "WHERE siswa.th_angkatan ='$dataTahun'";
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Pembayaran DKS per Angkatan </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN PEMBAYARAN DKS - PER ANGKATAN</h2>
<table width="800" border="0"  class="table-list">
  <tr>
    <td bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="160"><strong>Tahun Angkatan </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="611"><?php echo $dataTahun; ?></td>
  </tr>
</table>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="75" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="90" bgcolor="#F5F5F5"><strong>NIS</strong></td>
    <td width="235" bgcolor="#F5F5F5"><strong>Nama Siswa </strong></td>
    <td width="120" align="right" bgcolor="#F5F5F5"><strong>Bayar DKS  (Rp)</strong> </td>
    <td width="223" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
  </tr>
  <?php
  	// Skrip SQL menampilkan data pembayaran DKS per Tahun Angkatan Siswa
	$mySql = "SELECT pembayaran_dks.*, siswa.nama_siswa, siswa.nis FROM pembayaran_dks 
				LEFT JOIN siswa ON pembayaran_dks.kode_siswa = siswa.kode_siswa
				$filterSQL
				ORDER BY pembayaran_dks.tgl_bayar ASC"; 
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query biaya salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_bayar']); ?></td>
    <td><?php echo $myData['nis']; ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td align="right"><?php echo format_angka($myData['bayar_dks']); ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <?php } 

# Menthitung Total Uang DKS Terkumpul per Angkatan
$hitungSql 	= "SELECT SUM(bayar_dks) As total_dks FROM pembayaran_dks 
				LEFT JOIN siswa ON pembayaran_dks.kode_siswa = siswa.kode_siswa
				$filterSQL"; 
$hitungQry 	= mysql_query($hitungSql, $koneksidb) or die ("Error paging: ".mysql_error());
$hitungData	= mysql_fetch_array($hitungQry);
  ?>
  <tr>
    <td colspan="4" align="right"><strong>TOTAL (Rp) : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($hitungData['total_dks']); ?></strong></td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>