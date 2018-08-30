<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php"; 
?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td colspan="2" align="center"><h2><b>DATA JABATAN </b></h2></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Jabatan-Add" target="_self"><img src="images/btn_add_data.png" height="25" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<div class="table-responsive">
	<table class="table table-bordered" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="25" align="center" bgcolor="#999999"><strong>No</strong></td>
        <td width="60" bgcolor="#999999"><strong>Kode</strong></td>
        <td width="125" bgcolor="#999999"><strong>Nama Jabatan </strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
      </tr>
      <?php
	  // Skrip menampilkan data Jurusan
	$mySql = "SELECT * FROM jabatan ORDER BY kode_jabatan ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query jabatan salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kode_jabatan'];
		
		// Gradasi warna baris
		if($nomor%2==1) { $warna="#FFFFFF"; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kode_jabatan']; ?></td>
        <td><?php echo $myData['nama_jabatan']; ?></td>
        <td width="50" align="center"><a href="?open=Jabatan-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA JABATAN INI ... ?')">Delete</a></td>
        <td width="50" align="center"><a href="?open=Jabatan-Edit&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
      </tr>
      <?php } ?>
    </table></div></td>
  </tr>
</table>
