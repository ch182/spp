<?php
include_once "library/inc.ses_kasir.php";
include_once "library/inc.library.php"; 

# FILTER PEMBELIAN PER BULAN/TAHUN
# Bulan dan Tahun Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataBulan and $dataTahun) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(tgl_pembayaran,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		//$filterSQL = "WHERE LEFT(periode_awal,2)='$dataBulan' AND RIGHT(periode_awal,4)='$dataTahun' ";
		$filterSQL	= "WHERE LEFT(pembayaran.tgl_pembayaran,4)='$dataTahun' AND MID(pembayaran.tgl_pembayaran,6,2)='$dataBulan'";
	}
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
<h2 align="center"> <strong>DATA PEMBAYARAN SPP &amp; DSP </strong> </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" border="0"  class="table-list">
	<tr>
      <td width="184"><strong>Periode  </strong></td>
      <td width="25"><strong>:</strong></td>
      <td width="792"><select name="cmbBulan">
          <?php
		// Membuat daftar Nama Bulan
		$listBulan = array("00" => "....", "01" => "01. Januari", "02" => "02. Februari", "03" => "03. Maret",
						 "04" => "04. April", "05" => "05. Mei", "06" => "06. Juni", "07" => "07. Juli",
						 "08" => "08. Agustus", "09" => "09. September", "10" => "10. Oktober",
						 "11" => "11. November", "12" => "12. Desember");
						 
		// Menampilkan Nama Bulan ke ComboBox (List/Menu)
		foreach($listBulan as $bulanKe => $bulanNm) {
			if ($bulanKe == $dataBulan) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bulanKe' $cek>$bulanNm</option>";
		}
	  ?>
        </select>
          <select name="cmbTahun">
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
	  <td colspan="2" align="right"><a href="?open=Pembayaran-Add" target="_self"><img src="images/btn_add_data.png" height="25" border="0" /></a></td>
    </tr>
  </table>
</form>

	<div class="table-responsive">
	<table class="table table-bordered" width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" align="center" bgcolor="#999999"><strong>No</strong></td>
    <td width="55" bgcolor="#999999"><strong>Tanggal</strong></td>
    <td width="125" bgcolor="#999999"><strong>Periode</strong></td>
    <td width="50" bgcolor="#999999"><strong>NIS</strong></td>
    <td width="176" bgcolor="#999999"><strong>Nama Siswa </strong></td>
    <td width="116" align="right" bgcolor="#999999"><strong>Bayar DSP</strong></td>
    <td width="116" align="right" bgcolor="#999999"><strong>Bayar SPP</strong> </td>
    <td width="197" bgcolor="#999999"><strong>Keterangan</strong></td>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
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
    <td width="42" align="center"><a href="?open=Pembayaran-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PEMBAYARAN DSP & SPP INI ... ?')">Delete</a></td>
    <td width="45" align="center"><a href="pembayaran_nota.php?Kode=<?php echo $Kode; ?>" target="_blank" >Nota</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4"><b>Jumlah Data : <?php echo $jmlData; ?></b></td>
    <td colspan="6" align="right"><b>Halaman ke : </b>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Pembayaran-Data&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table></div>
<p><strong>SPP</strong> : Sumbangan Pendanaan Pendidikan. </p>
<p><strong>DSP</strong> : Dana Sumbangan Pembangunan</p>
