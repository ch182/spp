<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.connection.php";
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
		$filterSQL	= "WHERE kode_jurusan='$dataJurusan'";
	}
}
?>
<h2>LAPORAN DATA BIAYA SEKOLAH </h2>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-list">
<tr>
  <td bgcolor="#CCCCCC"><b>FILTER DATA </b></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="161"><b>Jurusan</b></td>
  <td width="8"><b>:</b></td>
  <td width="715"><select name="cmbJurusan">
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
</tr>
</table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="31" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="97" bgcolor="#CCCCCC"><strong>Angkatan </strong></td>
    <td width="181" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="135" align="right" bgcolor="#CCCCCC"><strong>DSP (Rp) </strong></td>
    <td width="135" align="right" bgcolor="#CCCCCC"><strong>SPP (Rp) </strong></td>
    <td width="152" align="right" bgcolor="#CCCCCC"><strong>DKS Putra(L) (Rp)</strong> </td>
    <td width="133" align="right" bgcolor="#CCCCCC"><strong>DKS Putri(P) (Rp) </strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM biaya_sekolah $filterSQL ORDER BY th_angkatan ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query biaya salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kode_biaya'];
		
		// Gradasi warna baris
		if($nomor%2==1) { $warna="#FFFFFF"; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['th_angkatan']; ?></td>
    <td bgcolor="<?php echo $warna; ?>"><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($myData['biaya_dsp']); ?></td>
    <td align="right"><?php echo format_angka($myData['biaya_spp']); ?></td>
    <td align="right"><?php echo format_angka($myData['biaya_dks_putra']); ?></td>
    <td align="right"><?php echo format_angka($myData['biaya_dks_putri']); ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/biaya_sekolah.php?kodeJur=<?php echo $dataJurusan; ?>" target="_blank"> 
<img src="images/btn_print2.png" width="20" border="0"/>
</a>