<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT * FROM guru";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($pageQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<h2>LAPORAN DATA GURU </h2>
<table class="table-list" width="850" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="29" height="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>NIP </strong></td>
    <td width="230" bgcolor="#CCCCCC"><strong>Nama Guru </strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>Kelamin</strong></td>
    <td width="245" bgcolor="#CCCCCC"><strong>Alamat</strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM guru ORDER BY kode_guru ASC LIMIT $mulai, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kode_guru'];
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
  <tr>
    <td colspan="4" bgcolor="#F5F5F5"><b>Jumlah data  :</b><?php echo $jumlah; ?></td>
    <td colspan="3" align="right" bgcolor="#F5F5F5"><b>Halaman ke :</b>
    <?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Laporan-Guru&hal=$h'>$h</a> ";
	}
	?>	</td>
  </tr>
</table>
<br />
<a href="cetak/guru.php" target="_blank"> 
<img src="images/btn_print2.png" width="20" border="0"/>
</a>