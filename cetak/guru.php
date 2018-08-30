<?php
session_start();
include_once "../library/inc.ses_admin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>:: Laporan Data Guru  </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN DATA GURU </h2>
<table class="table-list" width="850" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="29" height="23" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="60" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="80" bgcolor="#F5F5F5"><strong>NIP </strong></td>
    <td width="168" bgcolor="#F5F5F5"><strong>Nama Guru </strong></td>
    <td width="76" bgcolor="#F5F5F5"><strong>Kelamin</strong></td>
    <td width="301" bgcolor="#F5F5F5"><strong>Alamat</strong></td>
    <td width="100" bgcolor="#F5F5F5"><strong>No. Telepon </strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM guru ORDER BY kode_guru ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kode_guru']; ?></td>
    <td><?php echo $myData['nip']; ?></td>
    <td><?php echo $myData['nama_guru']; ?></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>