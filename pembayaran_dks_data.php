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
		$filterSQL = "WHERE LEFT(pembayaran_dks.tgl_bayar,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(pembayaran_dks.tgl_bayar,4)='$dataTahun' AND MID(pembayaran_dks.tgl_bayar,6,2)='$dataBulan'";
	}
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
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td align="center"><h2><strong>DATA PEMBAYARAN DKS</strong></h2></td>
  </tr>
  <tr>
    <td>
	
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" border="0"  class="table-list">
    <tr>
      <td width="184"><strong>Periode DKS </strong></td>
      <td width="25"><strong>:</strong></td>
      <td width="690"><select name="cmbBulan">
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
		$thnSql = "SELECT MIN(LEFT(tgl_bayar,4)) As tahun_bawah, MAX(LEFT(tgl_bayar,4)) As tahun_atas FROM pembayaran_dks";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		$thnBawah = $thnRow['tahun_bawah'];
		$thnAtas  = $thnRow['tahun_atas'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnBawah; $thn <= $thnAtas; $thn++) {
			if ($thn == $thnBawah) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select>
      <input name="btnTampil" type="submit" value="Tampil" /></td>
	  <td colspan="2" align="right"><a href="?open=Pembayaran-DKS-Add" target="_self"><img src="images/btn_add_data.png" height="25" border="0" /></a></td>
    </tr>
  </table>
</form>

	</td>
  </tr>

  <tr>
    <td><div class="table-responsive">
	<table class="table table-bordered" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="28" align="center" bgcolor="#999999"><strong>No</strong></td>
        <td width="68" bgcolor="#999999"><strong>Tanggal</strong></td>
        <td width="68" bgcolor="#999999"><strong>Periode</strong></td>
        <td width="92" bgcolor="#999999"><strong>NIS</strong></td>
        <td width="192" bgcolor="#999999"><strong>Nama Siswa </strong></td>
        <td width="192" align="right" bgcolor="#999999"><strong>Bayar DKS  (Rp)</strong> </td>
        <td width="194" bgcolor="#999999"><strong>Keterangan</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
      </tr>
      <?php
	$mySql = "SELECT pembayaran_dks.*, siswa.nama_siswa, siswa.nis FROM pembayaran_dks 
				LEFT JOIN siswa ON pembayaran_dks.kode_siswa = siswa.kode_siswa
				$filterSQL
				ORDER BY pembayaran_dks.tgl_bayar ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query biaya salah : ".mysql_error());
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_bayar_dks'];
		$KodeSiswa = $myData['kode_siswa'];
		
		// Gradasi warna baris
		if($nomor%2==1) { $warna="#FFFFFF"; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_bayar']); ?></td>
        <td>Ke-<?php echo $myData['periode_ke']; ?></td>
        <td><?php echo $myData['nis']; ?></td>
        <td><a href="?open=Laporan-Bayar-DKS-Siswa-Rincian&amp;KodeSiswa=<?php echo $KodeSiswa; ?>" target="_blank"><?php echo $myData['nama_siswa']; ?></a></td>
        <td align="right"><?php echo format_angka($myData['bayar_dks']); ?></td>
        <td><?php echo $myData['keterangan']; ?></td>
        <td width="45" align="center"><a href="?open=Pembayaran-DKS-Delete&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PEMBAYARAN DKS INI ... ?')">Delete</a></td>
        <td width="45" align="center"><a href="?open=Pembayaran-DKS-Edit&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="4"><b>Jumlah Data : <?php echo $jmlData; ?></b></td>
        <td colspan="5" align="right"><b>Halaman ke : </b>
            <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Pembayaran-DKS-Data&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
      </tr>
    </table></div></td>
  </tr>
</table>

<a href="?open=Pembayaran-DKS-Add" target="_self"></a>
<br />
<br />
<strong>DKS</strong> : Dana Kegiatan Siswa, dana DKS ini akan dikenakan tiap tahun dengan nilai yang sama pada setiap siswa dengan tahun angkatan yang sama.