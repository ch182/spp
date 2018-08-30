<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# FILTER PEMBELIAN PER BULAN/TAHUN
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataTahun) {
	// Membuat SQL Filter Data per Tahun dari Periode SPP/ DSP
	$filterSQL = "WHERE LEFT(tgl_pembayaran,4)='$dataTahun'";
}
else {
	$filterSQL = "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pembayaran $filterSQL"; 
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2>LAPORAN PEMBAYARAN SPP/DSP - PER PERIODE TAHUN</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="400" border="0"  class="table-list">
    <tr>
      <td bgcolor="#CCCCCC"><strong>FILTER DATA</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="114"><strong>Periode Tahun</strong></td>
      <td width="10"><strong>:</strong></td>
      <td width="262"><select name="cmbTahun">
        <?php
		# Baca tahun terendah(awal) di tabel Transaksi
		//$thnSql = "SELECT MIN(RIGHT(periode_awal,4)) As tahun_bawah,  MAX(RIGHT(periode_awal,4)) As tahun_atas FROM pembayaran";
		$thnSql = "SELECT MIN(LEFT(tgl_pembayaran,4)) As tahun_kecil, MAX(LEFT(tgl_pembayaran,4)) As tahun_besar FROM pembayaran";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		$thnKecil = $thnRow['tahun_kecil'];
		$thnBesar = $thnRow['tahun_besar'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnKecil; $thn <= $thnBesar; $thn++) {
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
	$mySql = "SELECT pembayaran.*, siswa.nama_siswa, siswa.nis FROM pembayaran 
				LEFT JOIN siswa ON pembayaran.kode_siswa = siswa.kode_siswa
				$filterSQL
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
		echo " <a href='?open=Laporan-Pembayaran-Tahun&hal=$list[$h]&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
<a href="cetak/pembayaran_tahun.php?tahun=<?php echo $dataTahun; ?>" target="_blank"> 
<img src="images/btn_print2.png" width="20" border="0"/>
</a>