<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

if(isset($_GET['Kode'])) {
	# Baca variabel URL
	$Kode = $_GET['Kode'];
	
	# MENAMPILKAN DATA PENJUALAN
	$mySql ="SELECT pembayaran.*, siswa.kode_siswa,  siswa.nis, siswa.nama_siswa 
				FROM pembayaran
				LEFT JOIN siswa ON pembayaran.kode_siswa = siswa.kode_siswa
				WHERE pembayaran.no_pembayaran='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query ".mysql_error());
	$myData= mysql_fetch_array($myQry);
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Nota Pembayaran</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> Cetak Pembayaran </h2>
<table width="450" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="158" bgcolor="#F5F5F5"><strong> DATA SISWA </strong></td>
    <td width="10">&nbsp;</td>
    <td width="254">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>NIS</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nis']; ?></td>
  </tr>
  <tr>
    <td><strong>Nama Siswa </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F5F5F5"><strong>PEMBAYARAN</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>No. <b>Pembayaran</b></strong></td>
    <td><b>:</b></td>
    <td><?php echo $myData['no_pembayaran']; ?></td>
  </tr>
  <tr>
    <td><b>Tgl. Pembayaran</b></td>
    <td><b>:</b></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembayaran']); ?></td>
  </tr>
  <tr>
    <td><strong>Periode Bayar <b></b></strong></td>
    <td><b>:</b></td>
    <td><?php echo $myData['periode_awal']." <b>s/d</b> ".$myData['periode_akhir']; ?></td>
  </tr>
  <tr>
    <td><strong>Bayar SPP (Rp) </strong></td>
    <td><b>:</b></td>
    <td><?php echo format_angka($myData['bayar_spp']); ?></td>
  </tr>
  <tr>
    <td><strong>Bayar DSP (Rp) </strong></td>
    <td><b>:</b></td>
    <td><?php echo format_angka($myData['bayar_dsp']); ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
</table>

<br/>
<img src="images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>