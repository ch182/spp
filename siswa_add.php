<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca Variabel Form
	$txtNis			= $_POST['txtNis'];
	$txtNama		= $_POST['txtNama'];
	$cmbKelamin		= $_POST['cmbKelamin'];
	$cmbAgama		= $_POST['cmbAgama'];
	$txtTempatLahir	= $_POST['txtTempatLahir'];
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$txtAlamat		= $_POST['txtAlamat'];
	$txtNoTelepon	= $_POST['txtNoTelepon'];
	$cmbJurusan		= $_POST['cmbJurusan'];
	$cmbAngkatan	= $_POST['cmbAngkatan'];
	$cmbBiaya		= $_POST['cmbBiaya'];
	$cmbStatus		= $_POST['cmbStatus'];
	
	// Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if(trim($txtNis)=="") {
		$pesanError[] = "Data <b>NIS Siswa</b> tidak boleh kosong, harus diisi !";		
	}
	else {
		// VALIDASI NIS DI DATABASE, jika sudah ada akan ditolak
		$sqlCek="SELECT * FROM siswa WHERE nis='$txtNis'";
		$qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($qryCek)>=1){
			$pesanError[] = "Maaf, NIS <b> $txtNis </b> sudah ada, ganti dengan yang lain";
		}
	}
	if(trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Siswa</b> tidak boleh kosong, harus diisi !";		
	}
	if(trim($cmbKelamin)=="Kosong") {
		$pesanError[] = "Data <b>Jenis Kelamin</b> belum dipilih !";		
	}
	if(trim($cmbAgama)=="Kosong") {
		$pesanError[] = "Data <b>Agama</b> belum dipilih !";		
	}
	if(trim($txtTempatLahir)=="") {
		$pesanError[] = "Data <b>Tempat Lahir</b> tidak boleh kosong, harus diisi !";		
	}
	if(trim($txtTanggal)=="") {
		$pesanError[] = "Data <b>Tanggal Lahir</b> tidak boleh kosong, harus diisi !";		
	}
	if(trim($txtAlamat)=="") {
		$pesanError[] = "Data <b>Alamat Tinggal</b> tidak boleh kosong, harus diisi !";		
	}
	if(trim($txtNoTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon </b> tidak boleh kosong, harus diisi !";		
	}
	if (trim($cmbJurusan)=="Kosong") {
		$pesanError[] = "Data <b>Jurusan</b> belum ada yang dipilih !";			
	}
	if(trim($cmbAngkatan)=="Kosong") {
		$pesanError[] = "Data <b>Tahun Angkatan</b> belum dipilih !";		
	}
	if(trim($cmbBiaya)=="Kosong") {
		$pesanError[] = "Data <b>Biaya (Sesuai Angkatan)</b> belum dipilih !";		
	}
	if(trim($cmbStatus)=="Kosong") {
		$pesanError[] = "Data <b>Status</b> belum dipilih !";		
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
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database			
		// Membuat Kode Siswa
		$kodeBaru	= buatKode("siswa", "S");

		# SKRIP UNTUK MENYIMPAN FOTO/GAMBAR
		if (! empty($_FILES['namaFile']['tmp_name'])) {
			// Membaca nama file foto/gambar
			$file_foto = $_FILES['namaFile']['name'];
			$file_foto = stripslashes($file_foto);
			$file_foto = str_replace("'","",$file_foto);
			
			// Simpan gambar
			$file_foto = $kodeBaru.".".$file_foto;
			copy($_FILES['namaFile']['tmp_name'],"foto/siswa/".$file_foto);
		}
		else {
			// Jika tidak ada foto/gambar
			$file_foto = "";
		}

		// Simpan data dari form ke Database
		$mySql	= "INSERT INTO siswa ( 
								kode_siswa, nis, nama_siswa,
								kelamin, agama, tempat_lahir, 
								tanggal_lahir, alamat, no_telepon, 
								foto, kode_jurusan, th_angkatan, kode_biaya, status)
							VALUES ( 
									'$kodeBaru', '$txtNis', '$txtNama', 
									'$cmbKelamin', '$cmbAgama', '$txtTempatLahir', 
									'$txtTanggal',  '$txtAlamat', '$txtNoTelepon', 
									'$file_foto', '$cmbJurusan', '$cmbAngkatan', '$cmbBiaya', '$cmbStatus')";		
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			// Setelah data disimpan, Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Siswa-Add'>";
		}
		exit;
	}	
} // Penutup POST

# MEMBUAT NILAI DATA PADA FORM
$kodeBaru		= buatKode("siswa", "S");
$dataNis		= isset($_POST['txtNis']) ? $_POST['txtNis'] : '';
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKelamin	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataAgama		= isset($_POST['cmbAgama']) ? $_POST['cmbAgama'] : '';
$dataTempatLahir= isset($_POST['txtTempatLahir']) ? $_POST['txtTempatLahir'] : '';
$dataTanggal	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataAlamat		= isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataNoTelepon	= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';
$dataJurusan	= isset($_POST['cmbJurusan']) ? $_POST['cmbJurusan'] : '';
$dataAngkatan	= isset($_POST['cmbAngkatan']) ? $_POST['cmbAngkatan'] : date('Y');
$dataBiaya		= isset($_POST['cmbBiaya']) ? $_POST['cmbBiaya'] : '';
$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="post" enctype="multipart/form-data" target="_self">
  <table class="table table-dark" width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><b>TAMBAH DATA SISWA</b></td>
    </tr>
    <tr>
      <td width="282"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="922"><input name="textfield" type="text" value="<?php echo $kodeBaru; ?>" size="10" maxlength="10" readonly="readonly"></td>
    </tr>
    <tr>
      <td><b>NIS</b></td>
      <td><b>:</b></td>
      <td><input name="txtNis" type="text" value="<?php echo $dataNis; ?>" size="40" maxlength="60"> </td>
    </tr>
    <tr>
      <td><b>Nama Siswa </b></td>
      <td><b>:</b></td>
      <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100"></td>
    </tr>
    <tr>
      <td><b>Jenis Kelamin </b></td>
      <td><b>:</b></td>
      <td><select name="cmbKelamin">
        <option value="Kosong">....</option>
        <?php
		   $pilihan = array("Laki-laki", "Perempuan");
          foreach ($pilihan as $kelamin) {
            if ($dataKelamin==$kelamin) {
                $cek="selected";
            } else { $cek = ""; }
            echo "<option value='$kelamin' $cek>$kelamin</option>";
          }
          ?>
      </select></td>
    </tr>
    <tr>
      <td><b>Agama</b></td>
      <td><b>:</b></td>
      <td><select name="cmbAgama">
        <option value="Kosong">....</option>
        <?php
		   $pilihan = array("Islam", "Kristen", "Katolik", "Hindu", "Budha");
          foreach ($pilihan as $agama) {
            if ($dataAgama==$agama) {
                $cek="selected";
            } else { $cek = ""; }
            echo "<option value='$agama' $cek>$agama</option>";
          }
          ?>
      </select></td>
    </tr>
    <tr>
      <td><strong>Tempat, Tgl Lahir </strong></td>
      <td><b>:</b></td>
      <td><input name="txtTempatLahir" type="text" value="<?php echo $dataTempatLahir; ?>" size="40" maxlength="100">
      , 
      <input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Alamat Lengkap </b></td>
      <td><b>:</b></td>
      <td><input name="txtAlamat" type="text" value="<?php echo $dataAlamat; ?>" size="80" maxlength="100"></td>
    </tr>
    <tr>
      <td><b>No. Telepon</b></td>
      <td><b>:</b></td>
      <td><input name="txtNoTelepon" type="text" value="<?php echo $dataNoTelepon; ?>" size="30" maxlength="30"></td>
    </tr>
    <tr>
      <td><strong>Foto Siswa </strong></td>
      <td><strong>:</strong></td>
      <td><input name="namaFile" type="file" size="60" /></td>
    </tr>
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
	  	echo "<option value='$dataRow[kode_jurusan]' $cek> $dataRow[nama_jurusan]</option>";
	  }
	  ?>
      </select>
      <input name="btnPilih" type="submit" id="btnPilih" value=" Pilih " /></td>
    </tr>
    <tr>
      <td><strong>Tahun Angkatan </strong></td>
      <td><b>:</b></td>
      <td><select name="cmbAngkatan">
        <option value="Kosong">....</option>
        <?php 
		for ($thn = date('Y') - 4; $thn <= date('Y'); $thn++) {
			if($thn==$dataAngkatan) { $cek=" selected";} else { $cek="";}
			echo "<option value='$thn' $cek>$thn</option>";
		}
		?>
      </select></td>
    </tr>
    <tr>
      <td><strong>Biaya SPP (Sesuai Angkatan) </strong></td>
      <td><b>:</b></td>
      <td><select name="cmbBiaya">
          <option value="Kosong">....</option>
          <?php
	  $dataSql = "SELECT * FROM biaya_sekolah WHERE kode_jurusan='$dataJurusan' ORDER BY th_angkatan";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataBiaya == $dataRow['kode_biaya']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kode_biaya]' $cek> $dataRow[th_angkatan]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><b>Status Aktif </b></td>
      <td><b>:</b></td>
      <td><select name="cmbStatus">
        <option value="Kosong">....</option>
        <?php
		   $pilihan = array("Aktif", "Lulus", "Keluar");
          foreach ($pilihan as $status) {
            if ($dataStatus==$status) {
                $cek="selected";
            } else { $cek = ""; }
            echo "<option value='$status' $cek>$status</option>";
          }
          ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" value=" Simpan "></td>
    </tr>
  </table>
</form>
