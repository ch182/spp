<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNIP			= $_POST['txtNIP'];
	$txtNama		= $_POST['txtNama'];
	$cmbKelamin		= $_POST['cmbKelamin'];
	$txtAlamat		= $_POST['txtAlamat'];
	$txtNoTelp		= $_POST['txtNoTelp'];
	$txtPendidikan	= $_POST['txtPendidikan'];
	$txtBidangStudi	= $_POST['txtBidangStudi'];
	$cmbStatus		= $_POST['cmbStatus'];
	$cmbJabatan		= $_POST['cmbJabatan'];

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if(trim($txtNIP)=="") {
		$pesanError[] = "Data <b>NIP</b> tidak boleh kosong, harus diisi !";		
	}
	if(trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Guru</b> tidak boleh kosong, harus diisi !";		
	}
	if(trim($cmbKelamin)=="Kosong") {
		$pesanError[] = "Data <b>Jenis Kelamin</b> belum dipilih !";		
	}
	if(trim($txtAlamat)=="") {
		$pesanError[] = "Data <b>Alamat Tinggal</b> tidak boleh kosong, harus diisi !";		
	}
	if(trim($txtNoTelp)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong, harus diisi !";		
	}
	if(trim($txtPendidikan)=="") {
		$pesanError[] = "Data <b>Pendidikan Terakhir</b> tidak boleh kosong, harus diisi !";		
	}
	if(trim($txtBidangStudi)=="") {
		$pesanError[] = "Data <b>Bidang Studi</b> tidak boleh kosong, harus diisi !";		
	}
	if(trim($cmbJabatan)=="Kosong") {
		$pesanError[] = "Data <b>Jabatan</b> belum dipilih !";		
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
		// Buat Kode Guru
		$kodeBaru	= buatKode("guru", "G");

		# SKRIP UNTUK MENYIMPAN FOTO/GAMBAR
		if (! empty($_FILES['namaFile']['tmp_name'])) {
			// Membaca nama file foto/gambar
			$file_foto = $_FILES['namaFile']['name'];
			$file_foto = stripslashes($file_foto);
			$file_foto = str_replace("'","",$file_foto);
			
			// Simpan gambar
			$file_foto = $kodeBaru.".".$file_foto;
			copy($_FILES['namaFile']['tmp_name'],"foto/guru/".$file_foto);
		}
		else {
			// Jika tidak ada foto/gambar
			$file_foto = "";
		}
		
		// Simpan data dari form ke Database
		$mySql	= "INSERT INTO guru ( 
								kode_guru, nip, nama_guru,
								kelamin, alamat, no_telepon, 
								pendidikan, bidang_studi, foto, status_aktif,kode_jabatan)
							VALUES ( 
									'$kodeBaru', '$txtNIP', '$txtNama', 
									'$cmbKelamin', '$txtAlamat', '$txtNoTelp', 
									'$txtPendidikan', '$txtBidangStudi', '$file_foto', '$cmbStatus', '$cmbJabatan')";		
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			// Setelah data disimpan, Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Guru-Add'>";
		}
		exit;
	}	
} // Penutup POST

# MEMBUAT NILAI DATA PADA FORM
$kodeBaru		= buatKode("guru", "G");
$dataNIP		= isset($_POST['txtNIP']) ? $_POST['txtNIP'] : '';
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKelamin	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataAlamat		= isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataNoTelp		= isset($_POST['txtNoTelp']) ? $_POST['txtNoTelp'] : '';
$dataPendidikan		= isset($_POST['txtPendidikan']) ? $_POST['txtPendidikan'] : '';
$dataBidangStudi	= isset($_POST['txtBidangStudi']) ? $_POST['txtBidangStudi'] : '';
$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
$dataJabatan	= isset($_POST['cmbJabatan']) ? $_POST['cmbJabatan'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="post" enctype="multipart/form-data" target="_self">
  <table class="table table-dark" width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><b>TAMBAH DATA GURU</b></td>
    </tr>
    <tr>
      <td width="233"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="971"><input name="textfield" type="text" value="<?php echo $kodeBaru; ?>" size="10" maxlength="8" readonly="readonly"></td>
    </tr>
    <tr>
      <td><b>NIP </b></td>
      <td><b>:</b></td>
      <td><input name="txtNIP" type="text" value="<?php echo $dataNIP; ?>" size="40" maxlength="60"> </td>
    </tr>
    <tr>
      <td><b>Nama Guru </b></td>
      <td><b>:</b></td>
      <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100"></td>
    </tr>
    <tr>
      <td><b> Kelamin </b></td>
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
      <td><b>Alamat Tinggal </b></td>
      <td><b>:</b></td>
      <td><input name="txtAlamat" type="text" value="<?php echo $dataAlamat; ?>" size="80" maxlength="100"></td>
    </tr>
    <tr>
      <td><b>No. Telepon </b></td>
      <td><b>:</b></td>
      <td><input name="txtNoTelp" type="text" value="<?php echo $dataNoTelp; ?>" size="30" maxlength="30"></td>
    </tr>
    <tr>
      <td><b>Pendidikan Terakhir </b></td>
      <td><b>:</b></td>
      <td><input name="txtPendidikan" type="text" value="<?php echo $dataPendidikan; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>Bidang Studi </b></td>
      <td><b>:</b></td>
      <td><input name="txtBidangStudi" type="text" value="<?php echo $dataBidangStudi; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Foto Guru </strong></td>
      <td><strong>:</strong></td>
      <td><input name="namaFile" type="file" size="60" /></td>
    </tr>
    <tr>
      <td><b>Status Aktif </b></td>
      <td><b>:</b></td>
      <td><select name="cmbStatus">
       <option value="Kosong">....</option>
       <?php
		   $pilihan = array("Aktif", "Tidak");
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
      <td><b>Jabatan</b></td>
      <td><b>:</b></td>
      <td><select name="cmbJabatan">
          <option value="Kosong">....</option>
          <?php
	  $dataSql = "SELECT * FROM jabatan ORDER BY kode_jabatan";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataJabatan == $dataRow['kode_jabatan']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kode_jabatan]' $cek> $dataRow[nama_jabatan]</option>";
	  }
	  ?>
      </select>
      <input name="btnPilih" type="submit" id="btnPilih" value=" Pilih " /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" value=" Simpan "></td>
    </tr>
  </table>
</form>
