<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# FILTER PEMBELIAN PER BULAN/TAHUN
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataTahun) {
	// Membuat SQL Filter Data per Tahun Pembayaran
	$filterSQL = "WHERE LEFT(pembayaran_dks.tgl_bayar,4)='$dataTahun'";
}
else {
	$filterSQL = "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pembayaran_dks $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2>LAPORAN PEMBAYARAN DKS - PER TAHUN BAYAR</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td bgcolor="#CCCCCC"><strong>FILTER DATA</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="165"><strong>Tahun Bayar  </strong></td>
      <td width="10"><strong>:</strong></td>
      <td width="711"><select name="cmbTahun">
        <?php
		# Baca tahun terendah(awal) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_bayar,4)) As tahun_bawah, MAX(LEFT(tgl_bayar,4)) As tahun_atas FROM pembayaran_dks";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		$thnBawah = $thnRow['tahun_bawah'];
		$thnAtas  = $thnRow['tahun_atas'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnBawah; $thn <= $thnAtas; $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
      </select>
      <input name="btnTampil" type="submit" value="Tampil" /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="29" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="85" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>NIS</strong></td>
    <td width="252" bgcolor="#CCCCCC"><strong>Nama Siswa </strong></td>
    <td width="121" align="right" bgcolor="#CCCCCC"><strong>Bayar DKS  (Rp)</strong> </td>
    <td width="302" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
  </tr>
  <?php
  	// Skrip SQL menampilkan data pembayaran DKS per Tahun Transaksi Bayar
	$mySql = "SELECT pembayaran_dks.*, siswa.nama_siswa, siswa.nis FROM pembayaran_dks 
				LEFT JOIN siswa ON pembayaran_dks.kode_siswa = siswa.kode_siswa
				$filterSQL
				ORDER BY pembayaran_dks.tgl_bayar ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query biaya salah : ".mysql_error());
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_bayar_dks'];
		
		// Gradasi warna baris
		if($nomor%2==1) { $warna="#FFFFFF"; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_bayar']); ?></td>
    <td><?php echo $myData['nis']; ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td align="right"><?php echo format_angka($myData['bayar_dks']); ?></td>
    <td>Ke-<?php echo $myData['periode_ke']; ?></td>
  </tr>
  <?php } 

# Menthitung Total Uang DKS Terkumpul per Angkatan
$hitungSql 	= "SELECT SUM(bayar_dks) As total_dks FROM pembayaran_dks $filterSQL";
$hitungQry 	= mysql_query($hitungSql, $koneksidb) or die ("Error paging: ".mysql_error());
$hitungData	= mysql_fetch_array($hitungQry);
  ?>
  <tr>
    <td colspan="4" align="right"><strong>TOTAL (Rp) : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($hitungData['total_dks']); ?></strong></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><b>Jumlah Data : <?php echo $jmlData; ?></b></td>
    <td colspan="2" align="right"><b>Halaman ke : </b>
        <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Bayar-DKS-Tahun&hal=$list[$h]&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
<a href="cetak/bayar_dks_tahun.php?tahun=<?php echo $dataTahun; ?>" target="_blank"> 
<img src="images/btn_print2.png" width="20" border="0"/>
</a>