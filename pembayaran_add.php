<?php
include_once "library/inc.ses_kasir.php";
include_once "library/inc.library.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$cmbBulan_a		= $_POST['cmbBulan_a'];
	$cmbTahun_a		= $_POST['cmbTahun_a'];
	$cmbBulan_b		= $_POST['cmbBulan_b'];
	$cmbTahun_b		= $_POST['cmbTahun_b'];
	$txtNIS			= $_POST['txtNIS'];
	$txtBayarDSP 	= $_POST['txtBayarDSP'];
	$txtBayarSPP 	= $_POST['txtBayarSPP'];
	$txtKeterangan	= $_POST['txtKeterangan'];

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tgl. Pembayaran</b> tidak boleh kosong, harus diisi angka !";		
	}
	if (trim($txtNIS)=="") {
		$pesanError[] = "Data <b>Nomor Induk Siswa (NIS)</b> tidak boleh kosong, harus diisi NIS !";	
	}
	else {
		// Validasi Kode NIS/ Kode Siswa apakah ada dalam database
		$cekSql	= "SELECT * FROM siswa WHERE kode_siswa='$txtNIS' OR nis='$txtNIS'";
		$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Error cek ".mysql_error());
		if(mysql_num_rows($cekQry) < 1) {
			$pesanError[] = "Data <b>NIS Tidak Dikenali</b>, data tidak ada dalam database !";
		}
	}
	if (trim($cmbBulan_a)=="" or trim($cmbTahun_a)=="")  {
		$pesanError[] = "Data <b>Periode Bulan & Tahun (Awal)</b> belum ada yang dipilih !";	
	}
	else {
		// Validasi Periode SPP, jika sudah dibayar maka beri pesan Error
		$cekSql	= "SELECT * FROM pembayaran As spp, siswa WHERE spp.kode_siswa = siswa.kode_siswa
					AND siswa.nis='$txtNIS' AND ( LEFT(spp.periode_awal,2)='$cmbBulan_a' AND RIGHT(spp.periode_akhir,4)='$cmbTahun_a')";
		$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Error cek ".mysql_error());
		if(mysql_num_rows($cekQry) >= 1) {
			$pesanError[] = "SPP Periode <b>$cmbBulan_a/$cmbTahun_a</b> telah dibayar, silahkan ganti Periode-nya !";
		} 
	}

	if (trim($cmbBulan_b)=="" or trim($cmbTahun_b)=="")  {
		$pesanError[] = "Data <b>Periode Bulan & Tahun (Akhir)</b> belum ada yang dipilih !";	
	}
	
	if (trim($cmbTahun_a) > trim($cmbTahun_b))  {
		$pesanError[] = "Data <b>Periode Tahun Awal & Akhir</b> belum sesuai !";	
	}
	
	if($cmbTahun_a == $cmbTahun_b) {
		if (trim($cmbBulan_a) > trim($cmbBulan_b))  {
			$pesanError[] = "Data <b>Periode Bulan Awal & Akhir</b> belum sesuai !";	
		}		
	}
	
	if (trim($txtBayarDSP)==""  or ! is_numeric(trim($txtBayarDSP))) {
		$pesanError[] = "Data <b>Bayar DSP (Rp)</b> tidak boleh kosong, harus diisi angka !";	
	}
	if (trim($txtBayarSPP)==""  or ! is_numeric(trim($txtBayarSPP))) {
		$pesanError[] = "Data <b>Bayar SPP (Rp)</b> tidak boleh kosong, harus diisi angka !";	
	}
	if (trim($txtKeterangan)=="")  {
		$pesanError[] = "Data <b>Keterangan</b> belum diisi !";	
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		// Membaca Kode Siswa
		$bacaSql	= "SELECT * FROM siswa WHERE kode_siswa='$txtNIS' OR nis='$txtNIS'";
		$bacaQry	= mysql_query($bacaSql, $koneksidb) or die ("Error baca siswa ".mysql_error());
		$bacaData	= mysql_fetch_array($bacaQry);
		$kodeSiswa	= $bacaData['kode_siswa'];
		
		$periode_awal	= "$cmbBulan_a/$cmbTahun_a";
		$periode_akhir	= "$cmbBulan_b/$cmbTahun_b";

		# SIMPAN DATA KE DATABASE. Jika jumlah error $pesanError tidak ada, simpan datanya
		$User	= $_SESSION['SES_LOGIN'];
		$kodeBaru	= buatKode("pembayaran", "SPP");
		$mySql	= "INSERT INTO pembayaran (no_pembayaran, tgl_pembayaran, periode_awal, periode_akhir, kode_siswa,  bayar_spp, bayar_dsp, keterangan, kode_user) 
					VALUES ('$kodeBaru', '$txtTanggal', '$periode_awal', '$periode_akhir', '$kodeSiswa', '$txtBayarSPP', '$txtBayarDSP', '$txtKeterangan', '$User')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query 1 : ".mysql_error());
		if($myQry){
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Pembayaran-Add'>";

			echo "<script>";
			echo "window.open('pembayaran_nota.php?Kode=$kodeBaru')";
			echo "</script>";
		}
		exit;
	}	
} // Penutup POST
	
# MEMBUAT NILAI DATA PADA FORM
$dataKode			= buatKode("pembayaran", "SPP");
$dataTanggal		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataBulan_a		= isset($_POST['cmbBulan_a']) ? $_POST['cmbBulan_a'] : date('m');
$dataTahun_a		= isset($_POST['cmbTahun_a']) ? $_POST['cmbTahun_a'] : date('Y');

$dataBulan_b		= isset($_POST['cmbBulan_b']) ? $_POST['cmbBulan_b'] : date('m');
$dataTahun_b		= isset($_POST['cmbTahun_b']) ? $_POST['cmbTahun_b'] : date('Y');

$dataNIS			= isset($_POST['txtNIS']) ? $_POST['txtNIS'] : '';
$dataNamaSiswa		= isset($_POST['txtNamaSiswa']) ? $_POST['txtNamaSiswa'] : '';
$dataBayarDSP		= isset($_POST['txtBayarDSP']) ? $_POST['txtBayarDSP'] : '0';
$dataBayarSPP		= isset($_POST['txtBayarSPP']) ? $_POST['txtBayarSPP'] : '0';
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';

# MENGHITUNG LAMA 
if($dataTahun_a == $dataTahun_b) {
	if($dataBulan_a == $dataBulan_b) {
		$jumlahBulan	= 1;
	}
	else {
		$jumlahBulan	= $dataBulan_b - $dataBulan_a + 1;
	}
}
else if($dataTahun_b > $dataTahun_a){
	$jumlahTahun	= $dataTahun_b - $dataTahun_a;
	
	if($jumlahTahun==1) {
		// Jika selisih Tahun hanya 1 ( 2016 - 2017 )
		$jumlahBulan	= (12 - $dataBulan_a) + $dataBulan_b + 1;
	}
	else {
		// Jika selisih Tahun lebih dari 1 (2016 - 2018 atau lebih)
		$bulanTahun		= ($jumlahTahun - 1) * 12;
		$jumlahBulan	= (12 - $dataBulan_a) + $dataBulan_b + $bulanTahun + 1;
	}
	//echo "JUMLAH BULAN : ($jumlahTahun) ".$jumlahBulan;
}
else {
	$jumlahBulan	= 0;
}


# SAAT KOTAK NIS DIINPUT DATA NOMOR SISWA, MAKA OTOMATIS FORM TERISI
# MEMBACA DATA BAYARAN SISWA. Saat NIS diinput, otomatis form akan Submit dan menjalankan skrip ini
if(isset($_POST['txtNIS'])) {
	$mySql ="SELECT biaya_sekolah.*, siswa.nis, siswa.nama_siswa 
				FROM biaya_sekolah, siswa WHERE biaya_sekolah.kode_biaya = siswa.kode_biaya
				AND siswa.nis='$dataNIS'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	if(mysql_num_rows($myQry) >=1) {
		$myData= mysql_fetch_array($myQry);
		$dataNIS		= $myData['nis'];
		$dataNamaSiswa	= $myData['nama_siswa'];
		$dataBayarDSP	= $jumlahBulan * $myData['biaya_dsp'];;
		$dataBayarSPP	= $jumlahBulan * $myData['biaya_spp'];;
	}
	else {
		// Jika tidak ditemukan, datanya disamapan dengan skrip form Post di atas
		$dataNIS		= $dataNIS;
		$dataNamaSiswa	= $dataNamaSiswa;
		$dataBayarDSP	= 0;
		$dataBayarSPP	= 0;
	}
}

# KLIK TOMBOL HITUNG
if(isset($_POST['btnHitung'])) {
	
}

# REFRENSI PERIODE
// Membuat daftar Nama Bulan
$listBulan = array("01" => "01. Januari", "02" => "02. Februari", "03" => "03. Maret",
				 "04" => "04. April", "05" => "05. Mei", "06" => "06. Juni", "07" => "07. Juli",
				 "08" => "08. Agustus", "09" => "09. September", "10" => "10. Oktober",
				 "11" => "11. November", "12" => "12. Desember");

// Baca tahun terendah(awal) di tabel Transaksi
$thnSql = "SELECT th_angkatan As tahun FROM siswa";
$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
$thnRow	= mysql_fetch_array($thnQry);
$tahun	= $thnRow['tahun'];
?>

<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
<table width="100%" cellpadding="2" cellspacing="1" class="table table-dark" style="margin-top:0px;">
  <tr>
    <td colspan="3"><h1><strong>PEMBAYARAN SPP</strong> &amp; DSP </h1></td>
  </tr>
  <tr>
    <td width="17%"><b>No. Pembayaran </b></td>
    <td width="1%"><b>:</b></td>
    <td width="82%"><input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td>
  </tr>
  <tr>
    <td><b>Tgl. Pembayaran </b></td>
    <td><b>:</b></td>
    <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="20" maxlength="20" /></td>
  </tr>
  <tr>
    <td bgcolor="#F5F5F5"><strong>DATA SISWA </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>NIS</b></td>
    <td><b>:</b></td>
    <td><input name="txtNIS" id="txtNIS" value="<?php echo $dataNIS; ?>" size="30" maxlength="12"  onChange="javascript:submitform();"/>
      <a href="javaScript: void(0)" onclick="popup('siswa_cari2.php')" target="_self"> <b>Cari Siswa </b></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><b>:</b></td>
    <td><input name="txtNamaSiswa" id="txtNamaSiswa" value="<?php echo $dataNamaSiswa; ?>" size="80" maxlength="100" readonly="readonly"/></td>
  </tr>
  <tr>
    <td bgcolor="#F5F5F5"><strong>PEMBAYARAN</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Periode (Bulan &amp; Tahun) </strong></td>
    <td><b>:</b></td>
    <td><select name="cmbBulan_a">
        <?php						 
		// Menampilkan Nama Bulan ke ComboBox (List/Menu)
		foreach($listBulan as $bulanKe => $bulanNm) {
			if ($bulanKe == $dataBulan_a) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bulanKe' $cek>$bulanNm</option>";
		}
	  ?>
      </select>
        <select name="cmbTahun_a">
          <?php
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $tahun; $thn <= date('Y'); $thn++) {
			if ($thn == $dataTahun_a) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
      </select> 
        <strong>S/D</strong> 
        <select name="cmbBulan_b">
          <?php
		// Menampilkan Nama Bulan ke ComboBox (List/Menu)
		foreach($listBulan as $bulanKe => $bulanNm) {
			if ($bulanKe == $dataBulan_b) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bulanKe' $cek>$bulanNm</option>";
		}
	  ?>
        </select>
        <select name="cmbTahun_b">
          <?php
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $tahun; $thn <= date('Y')+1; $thn++) {
			if ($thn == $dataTahun_b) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select>
        <input name="btnHitung" type="submit" id="btnHitung" style="cursor:pointer;" value=" Hitung " /></td>
  </tr>
  <tr>
    <td><strong>Lama (Bulan) </strong></td>
    <td><b>:</b></td>
    <td><strong><?php echo $jumlahBulan; ?></strong> bulan</td>
  </tr>
  <tr>
    <td><strong>Bayar DSP (Rp.) </strong></td>
    <td><b>:</b></td>
    <td><strong><?php echo format_angka($dataBayarDSP); ?> </strong>
	<input name="txtBayarDSP" id="txtBayarDSP" type="hidden" value="<?php echo $dataBayarDSP; ?>"/></td>
  </tr>
  <tr>
    <td><b>Bayar SPP (Rp.) </b></td>
    <td><b>:</b></td>
    <td><strong><?php echo format_angka($dataBayarSPP); ?>  </strong>
      <input name="txtBayarSPP" id="txtBayarSPP" type="hidden" value="<?php echo $dataBayarSPP; ?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>TOTAL BAYAR (Rp) </strong></td>
    <td><b>:</b></td>
    <td><strong><?php echo format_angka($dataBayarSPP + $dataBayarDSP); ?></strong></td>
  </tr>
  <tr>
    <td><b>Keterangan</b></td>
    <td><b>:</b></td>
    <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;" /></td>
  </tr>
</table>
</form>

