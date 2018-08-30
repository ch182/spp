<?php
session_start();
include_once "../library/inc.ses_admin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Membaca Kode Tahun Ajaran dari URL
$kodeSiswa	= isset($_GET['kodeSiswa']) ?  $_GET['kodeSiswa'] : '';
$kodeKelas	= isset($_GET['kodeKelas']) ?  $_GET['kodeKelas'] : '';
$semester	= isset($_GET['semester']) ?  $_GET['semester'] : '';

if(isset($kodeKelas) and isset($semester) and  isset($kodeSiswa)) {
	// SQL Filter data Nilai Raport
	$filterSQL = " WHERE nilai.kode_kelas='$kodeKelas' AND nilai.semester='$semester' AND nilai.kode_siswa='$kodeSiswa'";
		
	// Skrip untuk menampilkan informasi Kelas dan Siswa
	$infoSql = "SELECT * FROM kelas WHERE kode_kelas='$kodeKelas'";
	$infoQry = mysql_query($infoSql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$infoData= mysql_fetch_array($infoQry);
	
	// Skrip untuk menampilkan data Siswa
	$info2Sql = "SELECT * FROM siswa WHERE kode_siswa='$kodeSiswa'";
	$info2Qry = mysql_query($info2Sql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$info2Data= mysql_fetch_array($info2Qry);
}
else {
	$filterSQL = "";
	$filter2SQL = "";
	exit;
}
?>
<html>
<head>
<title>:: Nilai Raport Siswa</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>NILAI RAPORT SISWA </h1>
<table class="table-list" width="800" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
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
    <td><?php echo $infoData['nama_kelas']; ?></td>
  </tr>
  <tr>
    <td><strong>Semester</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $semester; ?></td>
  </tr>
  <tr>
    <td><strong>NIS</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $info2Data['nis']; ?></td>
  </tr>
  <tr>
    <td><strong>Nama Siswa </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $info2Data['nama_siswa']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#F5F5F5"><strong>NILAI</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table class="table-list"  width="800" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="27" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
        <td width="319" bgcolor="#F5F5F5"><strong>Mata Pelajaran </strong></td>
        <td width="66" bgcolor="#F5F5F5"><strong>Tugas 1 </strong></td>
        <td width="66" bgcolor="#F5F5F5"><strong>Tugas 2 </strong></td>
        <td width="66" bgcolor="#F5F5F5"><strong>UTS</strong></td>
        <td width="66" bgcolor="#F5F5F5"><strong>UAS</strong></td>
        <td width="154" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
      </tr>
      <?php
	$mySql = "SELECT nilai.*, pelajaran.nama_pelajaran FROM nilai
				LEFT JOIN pelajaran ON nilai.kode_pelajaran = pelajaran.kode_pelajaran
				$filterSQL
				ORDER BY nilai.kode_pelajaran ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
      <tr>
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['nama_pelajaran']; ?></td>
        <td><?php echo $myData['nilai_tugas1']; ?></td>
        <td><?php echo $myData['nilai_tugas2']; ?></td>
        <td><?php echo $myData['nilai_uts']; ?></td>
        <td><?php echo $myData['nilai_uas']; ?></td>
        <td><?php echo $myData['keterangan']; ?></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>