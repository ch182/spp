<?php
session_start();
include_once "../library/inc.ses_admin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

 // Membaca Kode Jurusan dari URL
$kodeJur	= isset($_GET['kodeJur']) ? $_GET['kodeJur'] : 'Kosong';
$tahun		= isset($_GET['tahun']) ?  $_GET['tahun'] : date('Y');

$filterSQL	= "";
if($kodeJur=="Kosong") {
	// jika jurusan tidak dipilih
	$filterSQL	= "";
	
	// info nama jurusan
	$jurusan	= "-";
}
else {
	// jika jurusan ada yang dipilih
	$filterSQL	= "WHERE kode_jurusan='$kodeJur'";
	
	// informasi nama jurusan
	$infoSql	= "SELECT * FROM jurusan WHERE kode_jurusan='$kodeJur'";
	$infoQry	= mysql_query($infoSql, $koneksidb);
	$infoData	= mysql_fetch_array($infoQry);
	
	$jurusan	= $infoData['nama_jurusan'];
}

?>
<html>
<head>
<title>:: Laporan Data Biaya Sekolah  </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2> LAPORAN DATA BIAYA SEKOLAH </h2>
<table class="table-list" width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="165"><strong>Jurusan </strong></td>
    <td width="17"><strong>:</strong></td>
    <td width="618"><?php echo $jurusan; ?></td>
  </tr>
</table>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="86" bgcolor="#F5F5F5"><strong>Angkatan </strong></td>
    <td width="177" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
    <td width="106" align="right" bgcolor="#F5F5F5"><strong>DSP (Rp) </strong></td>
    <td width="106" align="right" bgcolor="#F5F5F5"><strong>SPP (Rp) </strong></td>
    <td width="131" align="right" bgcolor="#F5F5F5"><strong>DKS Putra(L) (Rp)</strong> </td>
    <td width="131" align="right" bgcolor="#F5F5F5"><strong>DKS Putri(P) (Rp) </strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM biaya_sekolah $filterSQL ORDER BY th_angkatan ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query biaya salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['th_angkatan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($myData['biaya_dsp']); ?></td>
    <td align="right"><?php echo format_angka($myData['biaya_spp']); ?></td>
    <td align="right"><?php echo format_angka($myData['biaya_dks_putra']); ?></td>
    <td align="right"><?php echo format_angka($myData['biaya_dks_putri']); ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>