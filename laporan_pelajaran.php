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
		$filterSQL	= "WHERE kode_jurusan='$dataJurusan'";
	}
}
?>
<h2>LAPORAN DATA PELAJARAN </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table width="800" border="0" cellpadding="2" cellspacing="1" class="table-list">
<tr>
  <td bgcolor="#CCCCCC"><b>FILTER DATA </b></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="160"><b>Jurusan</b></td>
  <td width="8"><b>:</b></td>
  <td width="616"><select name="cmbJurusan">
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

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="61" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="339" bgcolor="#CCCCCC"><strong>Nama Pelajaran </strong></td>
    <td width="353" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
  </tr>
  <?php
  	// Skrip menampilkan data Pelajaran dari database
	$mySql = "SELECT * FROM pelajaran $filterSQL ORDER BY kode_pelajaran ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kode_pelajaran']; ?></td>
    <td><?php echo $myData['nama_pelajaran']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/pelajaran.php?kodeJur=<?php echo $dataJurusan; ?>" target="_blank"> 
<img src="images/btn_print2.png" width="20" border="0"/>
</a>