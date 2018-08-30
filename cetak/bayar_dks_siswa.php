<?php
session_start();
include_once "../library/inc.ses_pengajaran.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

 // Membaca Kode Jurusan dari URL
$kodeJur	= isset($_GET['kodeJur']) ? $_GET['kodeJur'] : 'Kosong';
$tahun		= isset($_GET['tahun']) ?  $_GET['tahun'] : date('Y');

$filterSQL	= "";
if($kodeJur=="Kosong") {
	// jika jurusan tidak dipilih
	$filterSQL	= "WHERE th_angkatan='$tahun'";
	
	// info nama jurusan
	$jurusan	= "-";
}
else {
	// jika jurusan ada yang dipilih
	$filterSQL	= "WHERE th_angkatan='$tahun' AND kode_jurusan='$kodeJur'";
	
	// informasi nama jurusan
	$infoSql	= "SELECT * FROM jurusan WHERE kode_jurusan='$kodeJur'";
	$infoQry	= mysql_query($infoSql, $koneksidb);
	$infoData	= mysql_fetch_array($infoQry);
	
	$jurusan	= $infoData['nama_jurusan'];
}
?>
<html>
<head>
<title>:: Laporan Pembayaran DKS per Siswa </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN PEMBAYARAN DKS - PER SISWA </h2>
<table width="800" border="0"  class="table-list">
  <tr>
    <td bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Jurusan </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $jurusan; ?></td>
  </tr>
  <tr>
    <td width="160"><strong>Tahun Angkatan </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="611"><?php echo $tahun; ?></td>
  </tr>
</table>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" rowspan="2" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="57" rowspan="2" bgcolor="#F5F5F5"><strong>NIS</strong></td>
    <td width="262" rowspan="2" bgcolor="#F5F5F5"><strong>Nama Siswa </strong></td>
    <td width="80" rowspan="2" bgcolor="#F5F5F5"><strong>Kelamin</strong></td>
    <td width="80" rowspan="2" bgcolor="#F5F5F5"><strong>Angkatan</strong></td>
    <td height="23" colspan="3" align="center" bgcolor="#F5F5F5"><strong>PEMBAYARAN DKS </strong></td>
  </tr>
  <tr>
    <td width="85" height="23" align="right" bgcolor="#F5F5F5"><strong>Tahun Ke-1 </strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong>Tahun Ke-2 </strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong>Tahun Ke-3 </strong></td>
  </tr>
  <?php
  	// Menampilkan daftar Siswa dengan Filter data per Tahun Angkatan
	$mySql = "SELECT * FROM siswa $filterSQL ORDER BY nama_siswa ASC"; 
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode 		= $myData['kode_siswa'];
		$KodeBiaya 	= $myData['kode_biaya'];
		
		// Membaca Biaya DKS yang diwajibkan Siswa, per Tahun Angkatan
		$my2Sql ="SELECT * FROM biaya_sekolah WHERE kode_biaya='$KodeBiaya'";
		$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Gagal Query 2 ".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);

		// Membedakan biaya DKS  Laki-laki (Putra) atau Perempuan (Putri)
		if($myData['kelamin']=="Laki-laki") {
			$dataBayarDKS	= $my2Data['biaya_dks_putra'];
		}
		elseif($myData['kelamin']=="Perempuan") {
			$dataBayarDKS	= $my2Data['biaya_dks_putri'];
		}
		else { 
			$dataBayarDKS	= 0;
		}

		$bayarDKS1	= "0";
		$bayarDKS2	= "0";
		$bayarDKS3	= "0";

		# Membaca Periode Tahun Ke (DSK dibayarkan tiap tahun selama Aktif Sekolah, 3 tahun)
		$my3Sql	= "SELECT * FROM pembayaran_dks WHERE kode_siswa='$Kode'";
		$my3Qry = mysql_query($my3Sql, $koneksidb) or die ("Gagal Query 3".mysql_error());
		while($my3Data= mysql_fetch_array($my3Qry)) {
			if($my3Data['periode_ke'] ==1) {
				$bayarDKS1	= $my3Data['bayar_dks'];
			}
			elseif($my3Data['periode_ke'] ==2) {
				$bayarDKS2	= $my3Data['bayar_dks'];
			}
			elseif($my3Data['periode_ke'] ==3) {
				$bayarDKS3	= $my3Data['bayar_dks'];
			}
			else {	}
		}
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['nis']; ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['th_angkatan']; ?></td>
    <td align="right"><?php echo format_angka($bayarDKS1); ?></td>
    <td width="85" align="right"><?php echo format_angka($bayarDKS2); ?></td>
    <td width="85" align="right"><?php echo format_angka($bayarDKS3); ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>