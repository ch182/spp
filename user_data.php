<?php
include_once "library/inc.ses_admin.php";
include_once "library/inc.library.php";
?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td align="center"><h2><b>DATA USER </b></h2></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=User-Add" target="_self"><img src="images/btn_add_data.png" height="25" border="0" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<div class="table-responsive">
	<table class="table table-bordered" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="25" bgcolor="#999999"><strong>No</strong></td>
        <td width="75" bgcolor="#999999"><strong>Kode</strong></td>
        <td width="365" bgcolor="#999999"><strong>Nama User</strong></td>
        <td width="205" bgcolor="#999999"><strong>Username</strong></td>
        <td width="100" bgcolor="#999999"><strong>Level</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
        </tr>
    <?php
	// Skrip menampilkan data User
	$mySql 	= "SELECT * FROM user ORDER BY kode_user ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kode_user'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kode_user']; ?></td>
        <td><?php echo $myData['nama_user']; ?></td>
        <td><?php echo $myData['username']; ?></td>
        <td><?php echo $myData['level']; ?></td>
        <td width="47" align="center"><a href="?open=User-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA USER INI ... ?')">Delete</a></td>
        <td width="46" align="center"><a href="?open=User-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
      </tr>
      <?php } ?>
    </table></div>	</td>
  </tr>
</table>

