<?php
session_start();
include_once "../library/inc.ses_admin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

$kodeKls	= isset($_GET['kodeKls']) ? $_GET['kodeKls'] : '';

# INTO TAHUN DAFTAR
if(isset($_GET['kodeKls'])) {
	$kodeKls = $_GET['kodeKls'];
	
	$infoSql = "SELECT kelas.*, guru.nama_guru FROM kelas 
				LEFT JOIN guru ON kelas.kode_guru = guru.kode_guru
				WHERE kelas.kode_kelas='$kodeKls'";
	$infoQry = mysql_query($infoSql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$infoData= mysql_fetch_array($infoQry);
}
else {
	echo "Tahun ajaran tidak terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Laporan Data Kelas </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2> LAPORAN DATA KELAS </h2>
<table class="table-list" width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#F5F5F5"><strong>INFORMASI</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="165"><strong>Tahun Ajaran </strong></td>
    <td width="17"><strong>:</strong></td>
    <td width="618"><?php echo $infoData['tahun_ajar']; ?></td>
  </tr>
  <tr>
    <td><strong>Nama Kelas </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $infoData['kelas']." | ".$infoData['nama_kelas']; ?></td>
  </tr>
  <tr>
    <td><strong>Wali Kelas  </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $infoData['nama_guru']; ?></td>
  </tr>
</table>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" height="23" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="86" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="96" bgcolor="#F5F5F5"><strong>NIS</strong></td>
    <td width="291" bgcolor="#F5F5F5"><strong>Nama Siswa </strong></td>
    <td width="76" bgcolor="#F5F5F5"><strong>Kelamin</strong></td>
    <td width="95" bgcolor="#F5F5F5"><strong>No. Telepon  </strong></td>
    <td width="94" bgcolor="#F5F5F5"><strong>Angkatan</strong></td>
  </tr>
  <?php
	$jkL	= 0;
  	$jkP 	= 0;
  	// Skrip menampilkan daftar Siswa dari tabel Kelas Siswa (kelas_siswa)
	$mySql = "SELECT siswa.* FROM kelas_siswa
				LEFT JOIN siswa ON kelas_siswa.kode_siswa = siswa.kode_siswa
			  	LEFT JOIN kelas ON kelas_siswa.kode_kelas = kelas.kode_kelas
			  WHERE kelas.kode_kelas='$kodeKls' 
			  ORDER BY kode_siswa ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		// Hitung berapa Jenis kelamin Perempuan(P) dan Laki-laki
		if($myData['kelamin']=="Perempuan") { $jkP = $jkP + 1; } else { $jkL = $jkL + 1;}
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kode_siswa']; ?></td>
    <td><?php echo $myData['nis']; ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
    <td><?php echo $myData['th_angkatan']; ?></td>
  </tr>
  <?php } ?>
</table>

<table class="table-list" width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#F5F5F5"><strong>STATISTIK</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="164"><strong>Perempuan (P) </strong></td>
    <td width="17"><strong>:</strong></td>
    <td width="119"><?php echo $jkP; ?></td>
  </tr>
  <tr>
    <td><strong>Laki-laki (L) </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $jkL; ?></td>
  </tr>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>