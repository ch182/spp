<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

// Jurusan Terpilih
$kodeJur		= isset($_GET['kodeJur']) ? $_GET['kodeJur'] : 'Kosong';
$dataJurusan	= isset($_POST['cmbJurusan']) ? $_POST['cmbJurusan'] : $kodeJur;

// Tahun Terpilih
$tahun 			= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataTahun 		= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun;

# FILTER DATA BERDASARKAN JURUSAN & TAHUN
$filterSQL	= "";
if($dataJurusan=="Kosong") {
	// jika jurusan tidak dipilih
	$filterSQL	= "WHERE th_angkatan='$dataTahun'";
}
else {
	// jika jurusan ada yang dipilih
	$filterSQL	= "WHERE th_angkatan='$dataTahun' AND kode_jurusan='$dataJurusan'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql	= "SELECT * FROM siswa $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2>LAPORAN PEMBAYARAN DKS - PER SISWA</h2>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<table width="900" border="0"  class="table-list">
  <tr>
    <td bgcolor="#CCCCCC"><strong> FILTER DATA </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>Jurusan</b></td>
    <td><b>:</b></td>
    <td><select name="cmbJurusan">
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
    </select></td>
  </tr>
  <tr>
    <td width="163"><strong> Th. Angkatan </strong></td>
    <td width="10"><strong>:</strong></td>
    <td width="713">
	<select name="cmbTahun">
	<option value="Semua"> .... </option>
      <?php
	  $dataSql = "SELECT th_angkatan FROM siswa GROUP BY th_angkatan ORDER BY th_angkatan";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataTahun == $dataRow['th_angkatan']) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[th_angkatan]' $cek>$dataRow[th_angkatan]</option>";
	  }
	  ?>
    </select>
        <input name="btnTampil" type="submit"  value="Tampil" /></td>
  </tr>
</table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="57" rowspan="2" bgcolor="#CCCCCC"><strong>NIS</strong></td>
    <td width="262" rowspan="2" bgcolor="#CCCCCC"><strong>Nama Siswa </strong></td>
    <td width="80" rowspan="2" bgcolor="#CCCCCC"><strong>Kelamin</strong></td>
    <td width="80" rowspan="2" bgcolor="#CCCCCC"><strong>Angkatan</strong></td>
    <td height="23" colspan="3" align="center" bgcolor="#CCCCCC"><strong>PEMBAYARAN DKS </strong></td>
  </tr>
  <tr>
    <td width="85" height="23" align="right" bgcolor="#CCCCCC"><strong>Tahun Ke-1  </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>Tahun Ke-2 </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>Tahun Ke-3  </strong></td>
  </tr>
  <?php
  	// Menampilkan daftar Siswa dengan Filter data per Tahun Angkatan
	$mySql = "SELECT * FROM siswa $filterSQL ORDER BY nama_siswa ASC LIMIT $halaman, $baris"; 
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode 		= $myData['kode_siswa'];
		$KodeBiaya 	= $myData['kode_biaya'];
		
		// Membaca Biaya DKS yang diwajibkan Siswa, per Tahun Angkatan
		$my2Sql ="SELECT * FROM biaya_sekolah WHERE kode_biaya='$KodeBiaya'";
		$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Gagal Query 2 ".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);

		// Membedakan biaya DKS  Laki-laki (Putra) atau Perempuan (Putri)
		if($myData['kelamin']=="Laki-laki") {
			$dataBayarDKS	= $my2Data['biaya_dks_putra'];
		}
		elseif($myData['kelamin']=="Perempuan") {
			$dataBayarDKS	= $my2Data['biaya_dks_putri'];
		}
		else { 
			$dataBayarDKS	= 0;
		}

		$bayarDKS1	= "0";
		$bayarDKS2	= "0";
		$bayarDKS3	= "0";

		# Membaca Periode Tahun Ke (DSK dibayarkan tiap tahun selama Aktif Sekolah, 3 tahun)
		$my3Sql	= "SELECT * FROM pembayaran_dks WHERE kode_siswa='$Kode'";
		$my3Qry = mysql_query($my3Sql, $koneksidb) or die ("Gagal Query 3".mysql_error());
		while($my3Data= mysql_fetch_array($my3Qry)) {
			if($my3Data['periode_ke'] ==1) {
				$bayarDKS1	= $my3Data['bayar_dks'];
			}
			elseif($my3Data['periode_ke'] ==2) {
				$bayarDKS2	= $my3Data['bayar_dks'];
			}
			elseif($my3Data['periode_ke'] ==3) {
				$bayarDKS3	= $my3Data['bayar_dks'];
			}
			else {	}
		}
				
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['nis']; ?></td>
    <td><a href="?open=Laporan-Bayar-DKS-Siswa-Rincian&KodeSiswa=<?php echo $Kode; ?>" target="_blank"><?php echo $myData['nama_siswa']; ?></a></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['th_angkatan']; ?></td>
    <td align="right"><?php echo format_angka($bayarDKS1); ?></td>
    <td width="85" align="right"><?php echo format_angka($bayarDKS2); ?></td>
    <td width="85" align="right"><?php echo format_angka($bayarDKS3); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><b>Jumlah Data :</b> <?php echo $jmlData; ?> </td>
    <td colspan="5" align="right"><b>Halaman ke :</b>
        <?php
		for ($h = 1; $h <= $maksData; $h++) {
			$list[$h] = $baris * $h - $baris;
			echo " <a href='?open=Laporan-Bayar-DKS-Siswa&hal=$list[$h]&tahun=$dataTahun&kodeJur=$dataJurusan'>$h</a> ";
		}
	?></td>
  </tr>
</table>
<br />
<a href="cetak/bayar_dks_siswa.php?tahun=<?php echo $dataTahun; ?>&kodeJur=<?php echo $dataJurusan; ?>" target="_blank"> 
<img src="images/btn_print2.png" width="20" border="0"/>
</a>