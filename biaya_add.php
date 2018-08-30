<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$cmbJurusan		= $_POST['cmbJurusan'];
	$txtAngkatan	= $_POST['txtAngkatan'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtBiayaDSP	= $_POST['txtBiayaDSP'];
	$txtBiayaSPP	= $_POST['txtBiayaSPP'];
	$txtBiayaDKSPutra 	= $_POST['txtBiayaDKSPutra'];
	$txtBiayaDKSPutri	= $_POST['txtBiayaDKSPutri'];

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($cmbJurusan)=="Kosong") {
		$pesanError[] = "Data <b>Jurusan</b> tidak boleh kosong !";	
	}
	if (trim($txtAngkatan)=="" or ! is_numeric(trim($txtAngkatan))) {
		$pesanError[] = "Data <b>TH. Angkatan</b> tidak boleh kosong, harus diisi angka !";		
	}
	else {
		// Harus 4 digit
		if(strlen($txtAngkatan) < 4) {
			$pesanError[] = "Data <b>TH. Angkatan</b> tidak boleh kosong, diisi tahun (4 digit) !";		
		}
		else {
			// Validasi, apakah Angkatan sudah dipakai di tabel biaya_sekolah atau belum
			$sqlCek	= "SELECT * FROM biaya_sekolah WHERE th_angkatan='$txtAngkatan' AND kode_jurusan='$cmbJurusan'";
			$qryCek	= mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
			if(mysql_num_rows($qryCek) >=1){
				$pesanError[] = "Maaf, <b>TH. Angkatan  $txtAngkatan </b> sudah ada, ganti dengan yang lain";
			}
		}
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";	
	}
	if (trim($txtBiayaDSP)==""  or ! is_numeric(trim($txtBiayaDSP))) {
		$pesanError[] = "Data <b>Biaya DSP (Rp.)</b> tidak boleh kosong, harus diisi angka !";	
	}
	if (trim($txtBiayaSPP)==""  or ! is_numeric(trim($txtBiayaSPP))) {
		$pesanError[] = "Data <b>Biaya SPP (Rp.)</b> tidak boleh kosong, harus diisi angka !";	
	}
	if (trim($txtBiayaDKSPutra)==""  or ! is_numeric(trim($txtBiayaDKSPutra))) {
		$pesanError[] = "Data <b>Biaya DKS Putra (Rp.)</b> tidak boleh kosong, harus diisi angka !";	
	}
	if (trim($txtBiayaDKSPutri)==""  or ! is_numeric(trim($txtBiayaDKSPutri))) {
		$pesanError[] = "Data <b>Biaya DKS Putri (Rp.)</b> tidak boleh kosong, harus diisi angka !";	
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
		# SIMPAN DATA KE DATABASE. Jika jumlah error $pesanError tidak ada, simpan datanya
		$kodeBaru	= buatKode("biaya_sekolah", "BS");
		$mySql	= "INSERT INTO biaya_sekolah (kode_biaya, kode_jurusan, th_angkatan, keterangan, biaya_dsp, biaya_spp, biaya_dks_putra, biaya_dks_putri) 
					VALUES ('$kodeBaru', '$cmbJurusan', '$txtAngkatan', '$txtKeterangan', '$txtBiayaDSP', '$txtBiayaSPP', '$txtBiayaDKSPutra', '$txtBiayaDKSPutri')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Biaya-Add'>";
		}
		exit;
	}	
} // Penutup POST
	
# MEMBUAT NILAI DATA PADA FORM
$dataKode			= buatKode("biaya_sekolah", "BS");
$dataJurusan		= isset($_POST['cmbJurusan']) ? $_POST['cmbJurusan'] : '';
$dataAngkatan		= isset($_POST['txtAngkatan']) ? $_POST['txtAngkatan'] : '';
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataBiayaDSP		= isset($_POST['txtBiayaDSP']) ? $_POST['txtBiayaDSP'] : '';
$dataBiayaSPP		= isset($_POST['txtBiayaSPP']) ? $_POST['txtBiayaSPP'] : '';
$dataBiayaDKSPutra	= isset($_POST['txtBiayaDKSPutra']) ? $_POST['txtBiayaDKSPutra'] : '';
$dataBiayaDKSPutri	= isset($_POST['txtBiayaDKSPutri']) ? $_POST['txtBiayaDKSPutri'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
<table width="100%" cellpadding="2" cellspacing="1" class="table table-dark" style="margin-top:0px;">
	<tr>
	  <td colspan="3" bgcolor="#F5F5F5"><strong>TAMBAH DATA BIAYA  SEKOLAH</strong></td>
	</tr>
	<tr>
	  <td width="20%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td></tr>
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
	  	echo "<option value='$dataRow[kode_jurusan]' $cek> $dataRow[nama_jurusan] - $dataRow[keterangan]</option>";
	  }
	  ?>
      </select></td>
    </tr>
	<tr>
	  <td><b>Th. Angkatan </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtAngkatan" value="<?php echo $dataAngkatan; ?>" size="10" maxlength="4" /></td>
	</tr>
	<tr>
      <td><b>Keterangan</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="60" maxlength="60" /></td>
    </tr>
	<tr>
      <td><b>Biaya DSP (Rp.)/ bulan </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtBiayaDSP" value="<?php echo $dataBiayaDSP; ?>" size="30" maxlength="12" /></td>
    </tr>
	<tr>
      <td><b>Biaya SPP (Rp.)/ bulan </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtBiayaSPP" value="<?php echo $dataBiayaSPP; ?>" size="30" maxlength="12" /></td>
    </tr>
	<tr>
      <td><b>Biaya DKS Putra (Rp.)</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtBiayaDKSPutra" value="<?php echo $dataBiayaDKSPutra; ?>" size="30" maxlength="12" /></td>
    </tr>
	<tr>
      <td><b>Biaya DKS Putri (Rp.)</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtBiayaDKSPutri" value="<?php echo $dataBiayaDKSPutri; ?>" size="30" maxlength="12" /></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
</form>
