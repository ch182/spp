<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# Tahun Terpilih
$tahun 			= isset($_GET['tahun']) ? $_GET['tahun'] : 'Semua';
$dataTahunAngk 	= isset($_POST['cmbTahunAngk']) ? $_POST['cmbTahunAngk'] : $tahun;

// Membaca data dari Pencarian
$kataKunci 	= isset($_GET['kataKunci']) ? $_GET['kataKunci'] : '';
$kataKunci 	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : $kataKunci;

// Membuat Sub SQL dengan Filter
if(trim($dataTahunAngk)=="Semua") {
	$filterSql = "WHERE siswa.th_angkatan != '$dataTahunAngk'";
}
else {
	$filterSql = "WHERE siswa.th_angkatan = '$dataTahunAngk'";
}

# TOMBOL CARI DIKLIK
if (isset($_POST['btnCari'])) {
	// Query dan filter pencarian
	$cariSql 	= $filterSql." AND ( siswa.nama_siswa LIKE '%".$kataKunci."%' OR siswa.nis ='$kataKunci')";
}
else {
	$cariSql 	= $filterSql;
}
 
# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql	= "SELECT * FROM siswa $cariSql";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pencarian Siswa</title>
<link href="styles/style_admin.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2"><h1><b>PENCARIAN SISWA </b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0"  class="table-list">
      <tr>
        <td bgcolor="#CCCCCC"><strong> PENCARIAN </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong> Th. Angkatan </strong></td>
        <td><strong>:</strong></td>
        <td><select name="cmbTahunAngk">
          <?php
	  $dataSql = "SELECT th_angkatan FROM siswa GROUP BY th_angkatan ORDER BY th_angkatan";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataTahunAngk == $dataRow['th_angkatan']) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[th_angkatan]' $cek>$dataRow[th_angkatan]</option>";
	  }
	  ?>
        </select></td>
      </tr>
      <tr>
        <td width="181"><strong>NIS / Nama  </strong></td>
        <td width="11"><strong>:</strong></td>
        <td width="688"><input name="txtKataKunci" type="text" value="<?php echo $kataKunci; ?>" size="40" maxlength="100" />
            <input name="btnCari" type="submit"  value="Cari" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong>* Kata Kunci : </strong>NIS &amp; Nama Siswa </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	  <table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td width="25" rowspan="2" align="center" bgcolor="#999999"><strong>No</strong></td>
          <td width="53" rowspan="2" bgcolor="#999999"><strong>NIS</strong></td>
          <td width="207" rowspan="2" bgcolor="#999999"><strong>Nama Siswa </strong></td>
          <td width="52" rowspan="2" bgcolor="#999999"><strong>Kelamin</strong></td>
          <td width="118" rowspan="2" bgcolor="#999999"><strong>Jurusan</strong></td>
          <td width="60" rowspan="2" bgcolor="#999999"><strong>Angkatan</strong></td>
          <td height="23" colspan="3" align="center" bgcolor="#999999"><strong>PEMBAYARAN  DSP</strong> </td>
          <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
        <tr>
          <td width="99" height="23" align="right"><strong>  DSP Wajib (Rp) </strong></td>
          <td width="86" align="right"><strong> Terbayar (Rp) </strong></td>
          <td width="101" align="right"><strong>Kekuarangn (Rp) </strong></td>
          </tr>
        <?php
		// Skrip menampilkan data Siswa hasil Pencarian
	$mySql = "SELECT siswa.*, jurusan.nama_jurusan FROM siswa 
				LEFT JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan 
				$cariSql ORDER BY nama_siswa ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kode_siswa'];
		$KodeBiaya = $myData['kode_biaya'];
		
		// Membaca Biaya DKS
		$my2Sql ="SELECT * FROM biaya_sekolah WHERE kode_biaya='$KodeBiaya'";
		$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Gagal Query 2 ".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);
		
		// Menghitung Biaya DSP yang sudah dibayarkan
		$my3Sql ="SELECT SUM(bayar_dsp) As total_dsp FROM pembayaran_dsp WHERE kode_siswa='$Kode'";
		$my3Qry = mysql_query($my3Sql, $koneksidb) or die ("Gagal Query 3 ".mysql_error());
		$my3Data= mysql_fetch_array($my3Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
        <tr bgcolor="<?php echo $warna; ?>">
          <td align="center"><?php echo $nomor; ?></td>
          <td><a href="#" onClick="window.opener.document.getElementById('txtNIS').value = '<?php echo $myData['nis']; ?>';
								 window.opener.document.getElementById('txtNamaSiswa').value = '<?php echo $myData['nama_siswa']; ?>';
								 window.close();"><b><?php echo $myData['nis']; ?></b></a></td>
          <td><?php echo $myData['nama_siswa']; ?></td>
          <td><?php echo $myData['kelamin']; ?></td>
          <td><?php echo $myData['nama_jurusan']; ?></td>
          <td><?php echo $myData['th_angkatan']; ?></td>
          <td align="right"><?php echo format_angka($my2Data['biaya_dsp']); ?></td>
          <td align="right"><?php echo format_angka($my3Data['total_dsp']); ?></td>
          <td align="right"><?php echo format_angka($my2Data['biaya_dsp']-$my3Data['total_dsp']); ?></td>
          <td width="42" align="center"><a href="cetak/siswa_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank">View</a></td>
          </tr>
        <?php } ?>
        <tr>
          <td colspan="3"><b>Jumlah Data :</b> <?php echo $jmlData; ?> </td>
          <td colspan="7" align="right"><b>Halaman ke :</b>
            <?php
		for ($h = 1; $h <= $maksData; $h++) {
			$list[$h] = $baris * $h - $baris;
			echo " <a href='siswa_cari.php?hal=$list[$h]&tahun=$tahun&kataKunci=$kataKunci'>$h</a> ";
		}
	?></td>
          </tr>
      </table>
	  </td>
  </tr>
</table>
</form>
</body>
</html>