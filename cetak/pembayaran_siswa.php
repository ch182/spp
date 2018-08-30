<?php
session_start();
include_once "../library/inc.ses_pengajaran.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

 // Membaca Kode Jurusan dari URL
$kodeJur	= isset($_GET['kodeJur']) ? $_GET['kodeJur'] : 'Semua';
$angkatan	= isset($_GET['angkatan']) ?  $_GET['angkatan'] : date('Y');

$filterSQL	= "";
if($kodeJur=="Semua") {
	// jika jurusan tidak dipilih
	$filterSQL	= "AND siswa.th_angkatan='$angkatan'";
	
	// info nama jurusan
	$jurusan	= "-";
}
else {
	// jika jurusan ada yang dipilih
	$filterSQL	= "AND siswa.th_angkatan='$angkatan' AND siswa.kode_jurusan='$kodeJur'";
	
	// informasi nama jurusan
	$infoSql	= "SELECT * FROM jurusan WHERE kode_jurusan='$kodeJur'";
	$infoQry	= mysql_query($infoSql, $koneksidb);
	$infoData	= mysql_fetch_array($infoQry);
	
	$jurusan	= $infoData['nama_jurusan'];
}

// Tahun kodeSiswa Terpilih
$kodeSiswa 			= isset($_GET['kodeSiswa']) ? $_GET['kodeSiswa'] : '';

// Membuat Sub SQL dengan Filter Siswa
if(trim($kodeSiswa)=="Semua") {
	$filterSQL_S 	= "";
	$namaSiswa		=	"-";
}
else {
	$filterSQL_S = "AND siswa.kode_siswa='$kodeSiswa'";

	// informasi nama Siswa
	$info2Sql	= "SELECT nis, nama_siswa FROM siswa WHERE kode_siswa='$kodeSiswa'";
	$info2Qry	= mysql_query($info2Sql, $koneksidb);
	$info2Data	= mysql_fetch_array($info2Qry);
	
	$namaSiswa	= $info2Data['nis']."/ ".$info2Data['nama_siswa'];
}
?>
<html>
<head>
<title>:: Laporan Pembayaran SPP per Siswa </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2> LAPORAN PEMBAYARAN SPP - PER SISWA</h2>
<table width="1000" border="0"  class="table-list">
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
    <td width="158"><strong>Angkatan</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="813"><?php echo $angkatan ?></td>
  </tr>
  <tr>
    <td><strong>Siswa</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $namaSiswa ?></td>
  </tr>
</table>
<table class="table-list" width="1000" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="28" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="69" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="111" bgcolor="#F5F5F5"><strong>Periode</strong></td>
    <td width="74" bgcolor="#F5F5F5"><strong>NIS</strong></td>
    <td width="201" bgcolor="#F5F5F5"><strong>Nama Siswa </strong></td>
    <td width="127" align="right" bgcolor="#F5F5F5"><strong>Bayar DSP  (Rp)</strong></td>
    <td width="127" align="right" bgcolor="#F5F5F5"><strong>Bayar SPP  (Rp)</strong> </td>
    <td width="222" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
  </tr>
  <?php
  	// Membuat Variabel
	$totalSPP	= 0;
	$totalDSP	= 0;
	
    // Menampilkan data Transaksi Pembayaran
	$mySql = "SELECT pembayaran.*, siswa.nama_siswa, siswa.nis FROM pembayaran, siswa
				WHERE pembayaran.kode_siswa = siswa.kode_siswa
				$filterSQL $filterSQL_S
				ORDER BY pembayaran.tgl_pembayaran ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query biaya salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_pembayaran'];
		$KodeSiswa = $myData['kode_siswa'];
		
		// Menjumlah
		$totalSPP	= $totalSPP + $myData['bayar_spp'];
		$totalDSP	= $totalDSP + $myData['bayar_dsp'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembayaran']); ?></td>
    <td><?php echo $myData['periode_awal']." <b>s/d</b> ".$myData['periode_akhir']; ?></td>
    <td><?php echo $myData['nis']; ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td align="right"><?php echo format_angka($myData['bayar_dsp']); ?></td>
    <td align="right"><?php echo format_angka($myData['bayar_spp']); ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <?php }  ?>
  <tr>
    <td colspan="5" align="right"><strong>TOTAL (Rp) :</strong> </td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalDSP); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalSPP); ?></strong></td>
    <td>&nbsp;</td>
  </tr>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>