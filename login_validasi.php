<?php 
if(isset($_POST['btnLogin'])){
	# Baca variabel form
	$txtUser 		= $_POST['txtUser'];
	$txtUser 		= str_replace("'","&acute;",$txtUser);
	
	$txtPassword	= $_POST['txtPassword'];
	$txtPassword	= str_replace("'","&acute;",$txtPassword);
	$cmbLevel		= $_POST['cmbLevel'];
	
	# Validasi form 
	$pesanError = array();
	if ( trim($txtUser)=="") {
		$pesanError[] = "Data <b> Username </b>  tidak boleh kosong !";		
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b> Password </b> tidak boleh kosong !";		
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
		
		// Tampilkan lagi form login
		include "login.php";
	}
	else {
		# LOGIN CEK KE TABEL USER LOGIN
		$loginSql = "SELECT * FROM user WHERE username='$txtUser' AND password='".md5($txtPassword)."'  AND level='$cmbLevel'";
		$loginQry = mysql_query($loginSql, $koneksidb) or die ("Query Salah : ".mysql_error());

		# JIKA LOGIN SUKSES
		if (mysql_num_rows($loginQry) >=1) {
			$loginData = mysql_fetch_array($loginQry);
			$_SESSION['SES_LOGIN'] 	= $loginData['kode_user']; 

			// Jika yang login Administrator
			if($cmbLevel=="Admin") {
				$_SESSION['SES_ADMIN'] = "ADMIN123";
			}
			elseif($cmbLevel=="Pengajaran") {
				// Jika yang login Petugas Pengajaran
				$_SESSION['SES_PENGAJARAN'] = "PENGAJARAN123";
			}
			elseif($cmbLevel=="Kasir") {
				// Jika yang login Petugas Pengajaran
				$_SESSION['SES_KASIR'] = "KASIR123";
			}
			else {
				$_SESSION['SES_USER'] = "";
			}
			
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open'>";
		}
	}
} // End POST
?>
 
