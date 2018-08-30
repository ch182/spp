<?php
session_start();
include_once "../library/inc.ses_pengajaran.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Kode Siswa
$KodeSiswa		= isset($_GET['KodeSiswa']) ? $_GET['KodeSiswa'] : '';

// Menampilkan daftar Siswa dengan Filter data per Tahun Angkatan
$mySql = "SELECT siswa.*, jurusan.nama_jurusan FROM siswa 
			LEFT JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan 
			WHERE siswa.kode_siswa='$KodeSiswa'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
$myData = mysql_fetch_array($myQry);
	$KodeBiaya 	= $myData['kode_biaya'];
	
	// Membaca Biaya DKS
	$my2Sql ="SELECT * FROM biaya_sekolah WHERE kode_biaya='$KodeBiaya'";
	$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Gagal Query 2 ".mysql_error());
	$my2Data= mysql_fetch_array($my2Qry);
?>
<html>
<head>
<title>:: Laporan Rincian Pembayaran DKS per Siswa </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN RINCIAN PEMBAYARAN DKS SISWA</h2>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<table width="800" border="0"  class="table-list">
  <tr>
    <td bgcolor="#CCCCCC"><strong> DATA SISWA </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>NIS</b></td>
    <td><b>:</b></td>
    <td><?php echo $myData['nis']; ?></td>
  </tr>
  <tr>
    <td width="161"><strong> Nama Siswa </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="610"><?php echo $myData['nama_siswa']; ?></td>
  </tr>
  <tr>
    <td><strong>Kelamin</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['kelamin']; ?></td>
  </tr>
  <tr>
    <td><strong>Angkatan</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['th_angkatan']; ?></td>
  </tr>
  <tr>
    <td><strong>Jurusan</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nama_jurusan']; ?></td>
  </tr>
</table>
</form>

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="24" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="116" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="186" bgcolor="#F5F5F5"><strong>Bayar DKS  (Rp)</strong> </td>
    <td width="453" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
  </tr>
  <?php
  	$totalTerbayar = 0;
	
	// Skrip menampilkan daftar pembayaran yang pernah dilakukan siswa
	$my3Sql = "SELECT * FROM pembayaran_dks WHERE kode_siswa='$KodeSiswa' ORDER BY tgl_bayar ASC";
	$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query biaya salah : ".mysql_error());
	$nomor = 0; 
	while ($my3Data = mysql_fetch_array($my3Qry)) {
		$nomor++;
		$Kode = $my3Data['no_bayar_dks'];
		
		// Menghitung total terbayar
		$totalTerbayar = $totalTerbayar + $my3Data['bayar_dks'];
		
		// Gradasi warna baris
		if($nomor%2==1) { $warna="#FFFFFF"; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($my3Data['tgl_bayar']); ?></td>
    <td align="right"><?php echo format_angka($my3Data['bayar_dks']); ?></td>
    <td><?php echo $my3Data['keterangan']; ?></td>
  </tr>
  <?php } 
  
  // Menghitung sisa kekurangan DKS yang belum dibayar
  $biayaDKS		 = 0;
  $totalKekurangan = 0;
  
  // Biaya DKS untuk Putra (Laki-laki) dan Putri (Perempuan) berbeda
  if($myData['kelamin']=="Laki-laki") {
	  $biayaDKS		 = $my2Data['biaya_dks_putri'];
  }
  else {
	  $biayaDKS		 = $my2Data['biaya_dks_putra'];
  }
  
  $totalKekurangan = $biayaDKS - $totalTerbayar;
  ?>
</table>
<p>&nbsp;</p>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>INFORMASI</strong></td>
  </tr>
  <tr>
    <td width="229"><strong>DKS Wajib (Rp) </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="242"><?php echo format_angka($biayaDKS); ?></td>
  </tr>
  <tr>
    <td><strong>Total DKS Terbayar (Rp) </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo format_angka($totalTerbayar); ?></td>
  </tr>
  <tr>
    <td><strong>Total DKS Belum Terbayar (Rp) </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo format_angka($totalKekurangan); ?></td>
  </tr>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>