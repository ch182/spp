<?php
include_once "library/inc.ses_kasir.php";
include_once "library/inc.library.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$txtNIS			= $_POST['txtNIS'];
	$txtPeriodeKe	= $_POST['txtPeriodeKe'];
	$txtBayarDKS 	= $_POST['txtBayarDKS'];
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
	if (trim($txtPeriodeKe)==""  or ! is_numeric(trim($txtPeriodeKe))) {
		$pesanError[] = "Data <b>Periode Ke</b> tidak boleh kosong, harus berisi angka !";	
	}
	if (trim($txtBayarDKS)==""  or ! is_numeric(trim($txtBayarDKS))) {
		$pesanError[] = "Data <b>Bayar DKS (Rp)</b> tidak boleh kosong, harus diisi angka !";	
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
		$Kode	= $_POST['txtKode'];
		$mySql	= "UPDATE pembayaran_dks SET tgl_bayar='$txtTanggal', periode_ke = '$txtPeriodeKe', kode_siswa = '$kodeSiswa', 
					bayar_dks = '$txtBayarDKS', keterangan = '$txtKeterangan', kode_user='$User'
					WHERE no_bayar_dks='$Kode'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query update".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Pembayaran-DKS-Data'>";
		}
		exit;
	}	
} // Penutup POST

# MEMBACA DATA DARI DATABASE
$Kode	= $_GET['Kode']; 
$mySql = "SELECT pembayaran_dks.*, siswa.nama_siswa, siswa.nis FROM pembayaran_dks 
			LEFT JOIN siswa ON pembayaran_dks.kode_siswa = siswa.kode_siswa
			WHERE no_bayar_dks='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	# MEMBUAT NILAI DATA PADA FORM
	$dataKode			= $myData['no_bayar_dks'];
	$dataTanggal		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : IndonesiaTgl($myData['tgl_bayar']);
	$dataPeriode		= isset($_POST['txtPeriode']) ? $_POST['txtPeriode'] : $myData['periode_ke']; 
	$dataNIS			= isset($_POST['txtNIS']) ? $_POST['txtNIS'] : $myData['nis'];
	$dataNamaSiswa		= isset($_POST['txtNamaSiswa']) ? $_POST['txtNamaSiswa'] : $myData['nama_siswa'];
	$dataBayarDKS		= isset($_POST['txtBayarDKS']) ? $_POST['txtBayarDKS'] : $myData['bayar_dks'];
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];


# MEMBACA DATA BAYARAN SISWA. Saat NIS diinput, otomatis form akan Submit dan menjalankan skrip ini
if(isset($_POST['txtNIS'])) {
	# Membaca besaran Biaya yang diwajibkan pada Siswa tersebut
	$mySql ="SELECT biaya_sekolah.*, siswa.kode_siswa, siswa.nis, siswa.nama_siswa, siswa.kelamin 
				FROM biaya_sekolah, siswa WHERE biaya_sekolah.kode_biaya = siswa.kode_biaya
				AND siswa.nis='$dataNIS'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	$myData= mysql_fetch_array($myQry);
	if(mysql_num_rows($myQry) >=1) {
		$dataNIS		= $myData['nis'];
		$dataNamaSiswa	= $myData['nama_siswa'];
	
		// Membedakan biaya DKS  Laki-laki (Putra) atau Perempuan (Putri)
		if($myData['kelamin']=="Laki-laki") {
			$dataBayarDKS	= $myData['biaya_dks_putra'];
		}
		elseif($myData['kelamin']=="Perempuan") {
			$dataBayarDKS	= $myData['biaya_dks_putri'];
		}
		else { 
			$dataBayarDKS	= $dataBayarDKS;
		}
	}
	else {
		// Jika tidak ditemukan, datanya disamapan dengan skrip form Post di atas
		$dataNIS		= $dataNIS;
		$dataNamaSiswa	= $dataNamaSiswa;
		$dataBayarDKS	= $dataBayarDKS;
	}
	
	# Membaca Periode Tahun Ke (DSK dibayarkan tiap tahun selama Aktif Sekolah, 3 tahun)
	$kodeSiswa	= $myData['kode_siswa'];
	$my2Sql	= "SELECT COUNT(*) AS jumlah FROM pembayaran_dks WHERE kode_siswa='$kodeSiswa'";
	$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Gagal Query 2".mysql_error());
	$my2Data= mysql_fetch_array($my2Qry);
	if($my2Data['jumlah'] >=1) {
		$dataPeriode	= $my2Data['jumlah'] + 1;
	}
	else {
		$dataPeriode	= 1;
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
	  <td colspan="3"><h1><strong>UBAH PEMBAYARAN DKS</strong></h1></td>
	</tr>
	<tr>
	  <td width="17%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="82%"><input name="textfield" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr>
	<tr>
      <td><b>Tgl. Bayar </b></td>
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
        <a href="javaScript: void(0)" onclick="popup('siswa_cari3.php')" target="_self"> <b>Cari Siswa </b></a></td>
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
      <td><strong>Periode Tahun Ke </strong></td>
	  <td><b>:</b></td>
	  <td><input name="txtPeriode" value="<?php echo $dataPeriode; ?>" size="10" maxlength="1" readonly="readonly"/>
      <input name="txtPeriodeKe" id="txtPeriodeKe" type="hidden" value="<?php echo $dataPeriode; ?>"/></td>
    </tr>
	<tr>
      <td><b>Bayar DKS (Rp) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtBayar" id="txtBayar" value="<?php echo $dataBayarDKS; ?>" size="30" maxlength="12" readonly="readonly"/>
        <input name="txtBayarDKS" id="txtBayarDKS"  type="hidden" value="<?php echo $dataBayarDKS; ?>" /></td>
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

