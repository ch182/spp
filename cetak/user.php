<?php
session_start();
include_once "../library/inc.ses_admin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title> :: Laporan Cetak Data User</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN DATA USER </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="31" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="81" bgcolor="#F5F5F5"><b>Kode</b></td>
    <td width="321" bgcolor="#F5F5F5"><b>Nama User</b></td>
    <td width="146" bgcolor="#F5F5F5"><b>Username</b></td>
    <td width="146" bgcolor="#F5F5F5"><b>Username</b></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM user ORDER BY kode_user ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kode_user']; ?></td>
    <td><?php echo $myData['nama_user']; ?></td>
    <td><?php echo $myData['username']; ?></td>
    <td><?php echo $myData['level']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>