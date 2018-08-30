<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php"; 

// Jurusan Terpilih
$kodeJur		= isset($_GET['kodeJur']) ? $_GET['kodeJur'] : 'Kosong';
$dataJurusan	= isset($_POST['cmbJurusan']) ? $_POST['cmbJurusan'] : $kodeJur;

# FILTER DATA BERDASARKAN JURUSAN & TAHUN
$filterSQL	= "";
if(isset($_POST['btnTampil'])) {
	if($dataJurusan=="Kosong") {
		// jika jurusan tidak dipilih
		$filterSQL	= "";
	}
	else {
		// jika jurusan ada yang dipilih
		$filterSQL	= "WHERE pelajaran.kode_jurusan='$dataJurusan'";
	}
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT * FROM pelajaran $filterSQL";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($pageQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td colspan="2" align="center"><h2><b>DATA PELAJARAN </b></h2></td>
  </tr>
  <tr>
    <td colspan="2">
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="table-list">
<tr>
  <td width="159"><b>Jurusan</b></td>
  <td width="25"><b>:</b></td>
  <td width="713"><select name="cmbJurusan">
    <option value="Kosong">....</option>
    <?php
	  $dataSql = "SELECT * FROM jurusan ORDER BY kode_jurusan";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataJurusan == $dataRow['kode_jurusan']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kode_jurusan]' $cek> $dataRow[nama_jurusan]</option>";
	  }
	  ?>
  </select>
    <input name="btnTampil" type="submit" value="Tampilkan" />    </td>
	<td colspan="2" align="right"><a href="?open=Pelajaran-Add" target="_self"><img src="images/btn_add_data.png" height="25" border="0" /></a></td>
</tr>
</table>
</form>
	
	</td>
  </tr>
  <tr>
    
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div class="table-responsive">
	<table class="table table-bordered" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="26" align="center" bgcolor="#999999"><strong>No</strong></td>
        <td width="60" bgcolor="#999999"><strong>Kode</strong></td>
        <td width="348" bgcolor="#999999"><strong>Nama Pelajaran </strong></td>
        <td width="158" bgcolor="#999999"><strong>Keterangan</strong></td>
        <td width="178" bgcolor="#999999"><strong>Jurusan</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
      </tr>
      <?php
	$mySql = "SELECT pelajaran.*, jurusan.nama_jurusan FROM pelajaran 
				LEFT JOIN jurusan ON pelajaran.kode_jurusan = jurusan.kode_jurusan 
				$filterSQL 
				ORDER BY pelajaran.kode_pelajaran ASC LIMIT $mulai, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query pelajaran salah : ".mysql_error());
	$nomor = $mulai;  
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kode_pelajaran'];
		
		// Gradasi warna baris
		if($nomor%2==1) { $warna="#FFFFFF"; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kode_pelajaran']; ?></td>
        <td><?php echo $myData['nama_pelajaran']; ?></td>
        <td><?php echo $myData['keterangan']; ?></td>
        <td><?php echo $myData['nama_jurusan']; ?></td>
        <td width="45" align="center"><a href="?open=Pelajaran-Edit&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
        <td width="45" align="center"><a href="?open=Pelajaran-Delete&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PELAJARAN INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="3" bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jumlah; ?> </td>
        <td colspan="4" align="right" bgcolor="#F5F5F5"><b>Halaman ke :</b>
          <?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Pelajaran-Data&hal=$h'>$h</a> ";
	}
	?></td>
        </tr>
    </table></div></td>
  </tr>
</table>
