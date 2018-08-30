<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

// Jurusan Terpilih
$kodeJur		= isset($_GET['kodeJur']) ? $_GET['kodeJur'] : 'Semua';
$dataJurusan	= isset($_POST['cmbJurusan']) ? $_POST['cmbJurusan'] : $kodeJur;

// Tahun Terpilih
$angkatan 			= isset($_GET['angkatan']) ? $_GET['angkatan'] : date('Y');
$dataAngkatan 		= isset($_POST['cmbAngkatan']) ? $_POST['cmbAngkatan'] : $angkatan;

# FILTER DATA BERDASARKAN JURUSAN & TAHUN
$filterSQL	= "";
if($dataJurusan=="Semua") {
	// jika jurusan tidak dipilih
	$filterSQL	= "AND siswa.th_angkatan='$dataAngkatan'";
}
else {
	// jika jurusan ada yang dipilih
	$filterSQL	= "AND siswa.th_angkatan='$dataAngkatan' AND siswa.kode_jurusan='$dataJurusan'";
}

// Tahun Periode Terpilih
$dataSiswa 	= isset($_POST['cmbSiswa']) ? $_POST['cmbSiswa'] : '';

// Membuat Sub SQL dengan Filter Kode Siswa
if(trim($dataSiswa)=="Semua") {
	$filterSQL_S = "";
}
else {
	$filterSQL_S = "AND pembayaran.kode_siswa='$dataSiswa'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql	= "SELECT * FROM pembayaran, siswa WHERE pembayaran.kode_siswa = siswa.kode_siswa $filterSQL $filterSQL_S";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>

<h2>LAPORAN PEMBAYARAN SPP/DSP - PER SISWA</h2>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<table width="400" border="0"  class="table-list">
  <tr>
    <td bgcolor="#CCCCCC"><strong> FILTER DATA </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>Jurusan</b></td>
    <td><b>:</b></td>
    <td><select name="cmbJurusan" onchange="javascript:submitform();">
        <option value="Semua">....</option>
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
    </select></td>
  </tr>
  <tr>
    <td width="111"><strong> Th. Angkatan </strong></td>
    <td width="5"><strong>:</strong></td>
    <td width="270">
	<select name="cmbAngkatan" onchange="javascript:submitform();">
	<option value="Semua"> .... </option>
      <?php
	  $dataSql = "SELECT th_angkatan FROM siswa GROUP BY th_angkatan ORDER BY th_angkatan";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query ComboBox 1".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataAngkatan == $dataRow['th_angkatan']) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[th_angkatan]' $cek>$dataRow[th_angkatan]</option>";
	  }
	  ?>
    </select></td>
  </tr>
  <tr>
    <td><strong>Siswa</strong></td>
    <td><strong>:</strong></td>
    <td><select name="cmbSiswa">
      <option value="Semua">....</option>
      <?php
	  $dataSql = "SELECT * FROM siswa, jurusan WHERE siswa.kode_jurusan= jurusan.kode_jurusan $filterSQL ORDER BY siswa.kode_siswa";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataSiswa == $dataRow['kode_siswa']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kode_siswa]' $cek> $dataRow[nis] - $dataRow[nama_siswa]</option>";
	  }
	  ?>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="btnTampil" type="submit"  value="Tampil" /></td>
  </tr>
</table>
</form>

<table class="table-list" width="1000" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="28" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="57" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="105" bgcolor="#F5F5F5"><strong>Periode</strong></td>
    <td width="68" bgcolor="#F5F5F5"><strong>NIS</strong></td>
    <td width="195" bgcolor="#F5F5F5"><strong>Nama Siswa </strong></td>
    <td width="121" align="right" bgcolor="#F5F5F5"><strong>Bayar DSP  (Rp)</strong></td>
    <td width="121" align="right" bgcolor="#F5F5F5"><strong>Bayar SPP  (Rp)</strong> </td>
    <td width="214" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
    <td align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
  </tr>
  <?php
    // Menampilkan data Transaksi Pembayaran
	$mySql = "SELECT pembayaran.*, siswa.nama_siswa, siswa.nis FROM pembayaran, siswa
				WHERE pembayaran.kode_siswa = siswa.kode_siswa
				$filterSQL $filterSQL_S
				ORDER BY pembayaran.tgl_pembayaran ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query biaya salah : ".mysql_error());
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_pembayaran'];
		$KodeSiswa = $myData['kode_siswa'];
		 
		// Gradasi warna baris
		if($nomor%2==1) { $warna="#FFFFFF"; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembayaran']); ?></td>
    <td><?php echo $myData['periode_awal']." <b>s/d</b> ".$myData['periode_akhir']; ?></td>
    <td><?php echo $myData['nis']; ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td align="right"><?php echo format_angka($myData['bayar_dsp']); ?></td>
    <td align="right"><?php echo format_angka($myData['bayar_spp']); ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td width="45" align="center"><a href="pembayaran_nota.php?Kode=<?php echo $Kode; ?>" target="_blank" >Nota</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4"><b>Jumlah Data : <?php echo $jmlData; ?></b></td>
    <td colspan="5" align="right"><b>Halaman ke : </b>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Pembayaran-Siswa&hal=$list[$h]&kodeJur=$dataJurusan&angkatan=$dataAngkatan&kodeSiswa=$dataSiswa'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
<a href="cetak/pembayaran_siswa.php?kodeJur=<?php echo $dataJurusan; ?>&angkatan=<?php echo $dataAngkatan; ?>&kodeSiswa=<?php echo $dataSiswa; ?>" target="_blank"> 
<img src="images/btn_print2.png" width="20" border="0"/>
</a>