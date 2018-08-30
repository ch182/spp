<?php
include_once "library/inc.ses_admin.php";
include_once "library/inc.library.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNama		= $_POST['txtNama'];
	$txtUsername	= $_POST['txtUsername'];
	$txtPassword	= $_POST['txtPassword'];
	$cmbLevel		= $_POST['cmbLevel'];
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama User</b> tidak boleh kosong !";		
	}
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong !";		
	}
	else {
		# VALIDASI USERNAME, jika sudah ada akan ditolak
		$cekSql="SELECT * FROM user WHERE username='$txtUsername'";
		$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($cekQry)>=1){
			$pesanError[] = "Maaf, Username <b> $txtUsername </b> sudah ada, ganti dengan yang lain";
		}
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b>Password</b> tidak boleh kosong !";		
	}
	if (trim($cmbLevel)=="Kosong") {
		$pesanError[] = "Data <b>Level</b> belum ada yang dipilih !";		
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
		$kodeBaru	= buatKode("user", "U");
		$mySql  	= "INSERT INTO user (kode_user, nama_user, username, password, level)
						VALUES ('$kodeBaru', '$txtNama', '$txtUsername', MD5('$txtPassword'), '$cmbLevel')";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=User-Add'>";
		}
		exit;
	}	
} // Penutup POST

# MEMBUAT ISI DATA PADA VARIABEL FORM
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode		= buatKode("user", "U");
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table table-dark" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <td colspan="3" bgcolor="#F5F5F5"><b>TAMBAH DATA USER</b></td>
    </tr>
    <tr>
      <td width="230"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="968"> <input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><b>Nama User </b></td>
      <td><b>:</b></td>
      <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>Username</b></td>
      <td><b>:</b></td>
      <td> <input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" size="40" maxlength="40" /></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><b>:</b></td>
      <td><input name="txtPassword" type="password"  size="40" maxlength="40" /></td>
    </tr>
    <tr>
      <td><b>Level</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbLevel">
          <option value="Kosong">....</option>
          <?php
		  $pilihan	= array("Pengajaran", "Kasir", "Admin");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" value=" Simpan " />      </td>
    </tr>
  </table>
</form>
