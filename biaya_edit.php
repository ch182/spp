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
			$Kode	= $_POST['txtKode'];
			$sqlCek	= "SELECT * FROM biaya_sekolah WHERE th_angkatan='$txtAngkatan' AND kode_jurusan='$cmbJurusan' AND NOT(kode_biaya='$Kode')";
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
		$pesanError[] = "Data <b>Biaya DSP (Rp)</b> tidak boleh kosong, harus diisi angka !";	
	}
	if (trim($txtBiayaSPP)==""  or ! is_numeric(trim($txtBiayaSPP))) {
		$pesanError[] = "Data <b>Biaya SPP (Rp)</b> tidak boleh kosong, harus diisi angka !";	
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
		$Kode	= $_POST['txtKode'];
		$mySql	= "UPDATE biaya_sekolah SET kode_jurusan='$cmbJurusan', th_angkatan='$txtAngkatan', biaya_dsp = '$txtBiayaDSP', biaya_spp = '$txtBiayaSPP',
					biaya_dks_putra = '$txtBiayaDKSPutra', biaya_dks_putri = '$txtBiayaDKSPutri', keterangan = '$txtKeterangan' 
					WHERE kode_biaya='$Kode'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query update".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Biaya-Data'>";
		}
		exit;
	}	
} // Penutup POST

# MEMBACA DATA DARI DATABASE
$Kode	= isset($_GET['Kode']) ? $_GET['Kode'] : null;
$mySql	= "SELECT * FROM biaya_sekolah WHERE kode_biaya='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	# MEMBUAT NILAI DATA PADA FORM
	$dataKode			= $myData['kode_biaya'];
	$dataJurusan		= isset($_POST['cmbJurusan']) ? $_POST['cmbJurusan'] : $myData['kode_jurusan'];
	$dataAngkatan		= isset($_POST['txtAngkatan']) ? $_POST['txtAngkatan'] : $myData['th_angkatan'];
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
	$dataBiayaDSP		= isset($_POST['txtBiayaDSP']) ? $_POST['txtBiayaDSP'] : $myData['biaya_dsp'];
	$dataBiayaSPP		= isset($_POST['txtBiayaSPP']) ? $_POST['txtBiayaSPP'] : $myData['biaya_spp'];
	$dataBiayaDKSPutra	= isset($_POST['txtBiayaDKSPutra']) ? $_POST['txtBiayaDKSPutra'] : $myData['biaya_dks_putra'];
	$dataBiayaDKSPutri	= isset($_POST['txtBiayaDKSPutri']) ? $_POST['txtBiayaDKSPutri'] : $myData['biaya_dks_putri'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
<table class="table table-dark" width="100%" style="margin-top:0px;">
	<tr>
	  <td colspan="3" bgcolor="#F5F5F5"><strong>UBAH DATA BIAYA SEKOLAH</strong></td>
	</tr>
	<tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr>
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

