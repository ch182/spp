<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

# Tahun Terpilih
$tahun 			= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataAjaran 	= isset($_POST['cmbAjaran']) ? $_POST['cmbAjaran'] : $tahun;

if(isset($dataAjaran)) {
	$filterSql	= "WHERE kelas.tahun_ajar = '$dataAjaran' ";
}
else {
	$filterSql	= "";
}
?>
<h2>LAPORAN DATA KELAS </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table width="800" border="0" cellpadding="2" cellspacing="1" class="table-list">
<tr>
  <td bgcolor="#F5F5F5"><b>FILTER DATA </b></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="161"><b>Tahun Ajaran </b></td>
  <td width="8"><b>:</b></td>
  <td width="615">
  <select name="cmbAjaran">
    <?php
	// Skrip menampilkan data Tahun Ajaran
  $dataSql = "SELECT tahun_ajar FROM kelas GROUP BY tahun_ajar ORDER BY tahun_ajar";
  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
  while ($dataRow = mysql_fetch_array($dataQry)) {
	if ($dataAjaran == $dataRow['tahun_ajar']) {
		$cek = " selected";
	} else { $cek=""; }
	echo "<option value='$dataRow[tahun_ajar]' $cek>$dataRow[tahun_ajar]</option>";
  }
  ?>
  </select>
    <strong>
    <input name="btnTampil" type="submit" value="Tampilkan" />
    </strong></td>
</tr>
</table>
</form>

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="24" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="45" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="90" bgcolor="#CCCCCC"><strong>T. Ajaran </strong></td>
    <td width="130" bgcolor="#CCCCCC"><strong>Jurusan</strong></td>
    <td width="107" bgcolor="#CCCCCC"><strong>Nama Kelas </strong></td>
    <td width="88" align="center" bgcolor="#CCCCCC"><strong> Qty Siswa</strong></td>
    <td width="236" bgcolor="#CCCCCC"><strong>Wali Kelas </strong></td>
    <td width="39" align="center" bgcolor="#F5F5F5"><strong>Tool</strong></td>
  </tr>
  <?php
	# Skrip menampilkan data Kelas dari database
	$mySql = "SELECT kelas.*, jurusan.nama_jurusan, guru.nama_guru FROM kelas
				LEFT JOIN jurusan ON kelas.kode_jurusan = jurusan.kode_jurusan
				LEFT JOIN guru ON kelas.kode_guru = guru.kode_guru
				$filterSql
				ORDER BY kelas.tahun_ajar, kelas.kode_kelas ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kode_kelas'];
		
		# Sub Skrip menghitung jumlah siswa
		$my2Sql = "SELECT COUNT(*) AS total_siswa FROM kelas_siswa WHERE kode_kelas='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kode_kelas']; ?></td>
    <td><?php echo $myData['tahun_ajar']; ?></td>
    <td><?php echo $myData['nama_jurusan']; ?></td>
    <td><?php echo $myData['kelas']." | ".$myData['nama_kelas']; ?></td>
    <td align="center"><?php echo $my2Data['total_siswa']; ?></td>
    <td><?php echo $myData['nama_guru']; ?></td>
    <td align="center"><a href="cetak/kelas_siswa.php?kodeKls=<?php echo $Kode; ?>" target="_blank" alt="View Data Kelas">Siswa</a></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/kelas.php?tahun=<?php echo $dataAjaran; ?>" target="_blank"> 
<img src="images/btn_print2.png" width="20" border="0"/>
</a>