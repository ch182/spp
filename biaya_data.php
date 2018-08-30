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
		$filterSQL	= "WHERE biaya_sekolah.kode_jurusan='$dataJurusan'";
	}
}
?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td colspan="2" align="center"><h2><b>DATA BIAYA SEKOLAH</b></h2></td>
  </tr>
  <tr>
    <td colspan="2">

	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="table-list">

<tr>
  <td width="153"><b>Jurusan</b></td>
  <td width="25"><b>:</b></td>
  <td width="719"><select name="cmbJurusan">
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
	 <td colspan="2" align="right"><a href="?open=Biaya-Add" target="_self"><img src="images/btn_add_data.png" height="25" border="0" /></a></td>
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
    <td colspan="2">
	<div class="table-responsive">
	<table class="table table-bordered" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="25" align="center" bgcolor="#999999"><strong>No</strong></td>
        <td width="70" bgcolor="#999999"><strong>Jurusan</strong></td>
        <td width="69" bgcolor="#999999"><strong>Angkatan </strong></td>
        <td width="90" bgcolor="#999999"><strong>Keterangan</strong></td>
        <td width="121" align="right" bgcolor="#999999"><strong>DSP (Rp)/ bln </strong></td>
        <td width="121" align="right" bgcolor="#999999"><strong>SPP (Rp)/ bln </strong></td>
        <td width="150" align="right" bgcolor="#999999"><strong>DKS Putra(L) (Rp) </strong></td>
        <td width="150" align="right" bgcolor="#999999"><strong>DKS Putri(P) (Rp) </strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
      </tr>
      <?php
	  // Skrip menampilkan data Biaya Sekolah
	$mySql = "SELECT biaya_sekolah.*, jurusan.nama_jurusan FROM biaya_sekolah 
				LEFT JOIN jurusan ON biaya_sekolah.kode_jurusan = jurusan.kode_jurusan
				$filterSQL ORDER BY biaya_sekolah.th_angkatan ASC";
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
        <td><?php echo $myData['nama_jurusan']; ?></td>
        <td><?php echo $myData['th_angkatan']; ?></td>
        <td bgcolor="<?php echo $warna; ?>"><?php echo $myData['keterangan']; ?></td>
        <td align="right"><?php echo format_angka($myData['biaya_dsp']); ?></td>
        <td align="right"><?php echo format_angka($myData['biaya_spp']); ?></td>
        <td align="right"><?php echo format_angka($myData['biaya_dks_putra']); ?></td>
        <td align="right"><?php echo format_angka($myData['biaya_dks_putri']); ?></td>
        <td width="39" align="center"><a href="?open=Biaya-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BIAYA INI ... ?')">Delete</a></td>
        <td width="30" align="center"><a href="?open=Biaya-Edit&;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
      </tr>
      <?php } ?>
    </table></div></td>
  </tr>
</table>
<strong>Keterangan :</strong> Biaya Sekolah di atas akan diterapkan pada Semua Siswa dengan tahun angkatan yang sama
