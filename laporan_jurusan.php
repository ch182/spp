<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";
?>
<h2>LAPORAN DATA JURUSAN </h2>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="50" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="200" bgcolor="#CCCCCC"><strong>Nama Jurusan </strong></td>
    <td width="404" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM jurusan ORDER BY kode_jurusan ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kode_jurusan']; ?></td>
    <td><?php echo $myData['nama_jurusan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/jurusan.php" target="_blank"> 
<img src="images/btn_print2.png" width="20" border="0"/>
</a>