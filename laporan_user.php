<?php
include_once "library/inc.ses_admin.php";
include_once "library/inc.library.php";
?>
<h2>LAPORAN DATA USER </h2>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="30" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="80" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="419" bgcolor="#F5F5F5"><strong>Nama User</strong></td>
    <td width="150" bgcolor="#F5F5F5"><strong>Username</strong></td>  
    <td width="150" bgcolor="#F5F5F5"><strong>Level</strong></td>
  </tr>
	<?php
	$mySql = "SELECT * FROM user ORDER BY kode_user ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor	 = 0; 
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
<br />
<a href="cetak/user.php" target="_blank"> <img src="images/btn_print2.png" width="20" border="0"/> </a>