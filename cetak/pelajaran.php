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
<title>:: Laporan Data Pelajaran </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2> LAPORAN DATA PELAJARAN </h2>
<table class="table-list" width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="163"><strong>Jurusan </strong></td>
    <td width="17"><strong>:</strong></td>
    <td width="620"><?php echo $jurusan; ?></td>
  </tr>
</table>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="56" bgcolor="#F5F5F5"><b>Kode</b></td>
    <td width="342" bgcolor="#F5F5F5"><b>Nama Pelajaran </b></td>
    <td width="355" bgcolor="#F5F5F5"><b>Keterangan</b></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM pelajaran $filterSQL ORDER BY kode_pelajaran ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kode_pelajaran']; ?></td>
    <td><?php echo $myData['nama_pelajaran']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>