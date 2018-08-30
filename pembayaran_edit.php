<?php
include_once "library/inc.ses_kasir.php";
include_once "library/inc.library.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$cmbBulan		= $_POST['cmbBulan'];
	$cmbTahun		= $_POST['cmbTahun'];
	$txtNIS			= $_POST['txtNIS'];
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
	if (trim($cmbBulan)=="" or trim($cmbTahun)=="")  {
		$pesanError[] = "Data <b>Periode Bulan & Tahun </b> belum ada yang dipilih !";	
	}
	else {
		// Validasi Periode SPP, jika sudah dibayar maka beri pesan Error
		$Kode	= $_POST['txtKode'];
		$cekSql	= "SELECT * FROM pembayaran As spp, siswa WHERE spp.kode_siswa = siswa.kode_siswa
					AND siswa.nis='$txtNIS' AND ( LEFT(spp.periode,2)='$cmbBulan' AND RIGHT(spp.periode,4)='$cmbTahun')
					AND NOT(no_pembayaran='$Kode')";
		$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Error cek ".mysql_error());
		if(mysql_num_rows($cekQry) >= 1) {
			$pesanError[] = "SPP Periode <b>$cmbBulan/$cmbTahun</b> telah dibayar, silahkan ganti Periode-nya !";
		}		
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

		# SIMPAN DATA KE DATABASE. Jika jumlah error $pesanError tidak ada, simpan datanya
		$User	= $_SESSION['SES_LOGIN'];
		$periode	= "$cmbBulan/$cmbTahun";
		$Kode	= $_POST['txtKode'];
		$mySql	= "UPDATE pembayaran SET tgl_pembayaran='$txtTanggal', periode = '$periode', kode_siswa = '$kodeSiswa', 
					bayar_spp = '$txtBayarSPP', keterangan = '$txtKeterangan', kode_user = '$User' 
					WHERE no_pembayaran='$Kode'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query update".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Pembayaran-SPP-Data'>";
		}
		exit;
	}	
} // Penutup POST

# MEMBACA DATA DARI DATABASE
$Kode	= $_GET['Kode']; 
$mySql = "SELECT pembayaran.*, siswa.nama_siswa, siswa.nis FROM pembayaran 
			LEFT JOIN siswa ON pembayaran.kode_siswa = siswa.kode_siswa
			WHERE no_pembayaran='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	# MEMBUAT NILAI DATA PADA FORM
	$dataKode			= $myData['no_pembayaran'];
	$dataTanggal		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : IndonesiaTgl($myData['tgl_pembayaran']);
	$dataBulan			= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : substr($myData['periode'], 0, 2); 
	$dataTahun			= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : substr($myData['periode'], 3, 7);
	$dataNIS			= isset($_POST['txtNIS']) ? $_POST['txtNIS'] : $myData['nis'];
	$dataNamaSiswa		= isset($_POST['txtNamaSiswa']) ? $_POST['txtNamaSiswa'] : $myData['nama_siswa'];
	$dataBayarSPP		= isset($_POST['txtBayarSPP']) ? $_POST['txtBayarSPP'] : $myData['bayar_spp'];
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];


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
		$dataBayarSPP	= $myData['biaya_spp'];;
	}
	else {
		// Jika tidak ditemukan, datanya disamapan dengan skrip form Post di atas
		$dataNIS		= $dataNIS;
		$dataNamaSiswa	= $dataNamaSiswa;
		$dataBayarSPP	= $dataBayarSPP;
	}
}
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
<table class="table table-dark" width="100%" style="margin-top:0px;">
	<tr>
	  <td colspan="3"><h1><strong>UBAH PEMBAYARAN SPP</strong></h1></td>
	</tr>
	<tr>
	  <td width="17%"><b>No. Pembayaran</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="82%"><input name="textfield" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr>
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
	  <td><input name="txtNIS" id="txtNIS" value="<?php echo $dataNIS; ?>" size="30" maxlength="12" onChange="javascript:submitform();"/>
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
	  <td><select name="cmbBulan">
          <?php
		// Membuat daftar Nama Bulan
		$listBulan = array("01" => "01. Januari", "02" => "02. Februari", "03" => "03. Maret",
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
		$thnSql = "SELECT th_angkatan As tahun FROM siswa";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		$tahun	= $thnRow['tahun'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $tahun; $thn <= date('Y'); $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select></td>
    </tr>
	<tr>
      <td><b>Bayar SPP (Rp) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtBayar" id="txtBayar" value="<?php echo $dataBayarSPP; ?>" size="30" maxlength="12" readonly="readonly"/>
        <input name="txtBayarSPP" id="txtBayarSPP" type="hidden" value="<?php echo $dataBayarSPP; ?>" /></td>
    </tr>
	<tr>
      <td><b>Keterangan</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
</form>

