<?php
session_start();
include_once "../library/inc.ses_pengajaran.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# FILTER PEMBELIAN PER BULAN/TAHUN
$dataBulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataTahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang

# Membuat Filter Bulan
if($dataBulan and $dataTahun) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(tgl_pembayaran,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL	= "WHERE LEFT(pembayaran.tgl_pembayaran,4)='$dataTahun' AND MID(pembayaran.tgl_pembayaran,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

// Membuat daftar bulan
$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");
?>
<html>
<head>
<title>:: Laporan Pembayaran SPP per Bulan </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> LAPORAN PEMBAYARAN SPP/DSP - PER PERIODE BULAN</h2>
<table width="1000" border="0"  class="table-list">
  <tr>
    <td bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="159"><strong>Periode Bulan</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="812"><?php echo $listBulan[$dataBulan]; ?>, <?php echo $dataTahun; ?></td>
  </tr>
</table>
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
  </tr>
  <?php
    // Menampilkan data Transaksi Pembayaran
	$mySql = "SELECT pembayaran.*, siswa.nama_siswa, siswa.nis FROM pembayaran 
				LEFT JOIN siswa ON pembayaran.kode_siswa = siswa.kode_siswa
				$filterSQL
				ORDER BY pembayaran.tgl_pembayaran ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query biaya salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_pembayaran'];
		$KodeSiswa = $myData['kode_siswa'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembayaran']); ?></td>
    <td><?php echo $myData['periode_awal']." <b>s/d</b> ".$myData['periode_akhir']; ?></td>
    <td><?php echo $myData['nis']; ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td align="right"><?php echo format_angka($myData['bayar_dsp']); ?></td>
    <td align="right"><?php echo format_angka($myData['bayar_spp']); ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <?php } 

	# Menthitung Total Uang SPP Terkumpul per Angkatan
	$hitungSql 	= "SELECT SUM(bayar_spp) As total_spp, SUM(bayar_dsp) As total_dsp FROM pembayaran $filterSQL";
	$hitungQry 	= mysql_query($hitungSql, $koneksidb) or die ("Error paging: ".mysql_error());
	$hitungData	= mysql_fetch_array($hitungQry);
  ?>
  <tr>
    <td colspan="5" align="right"><strong>TOTAL (Rp) :</strong> </td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($hitungData['total_dsp']); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($hitungData['total_spp']); ?></strong></td>
    <td>&nbsp;</td>
  </tr>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>