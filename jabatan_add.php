<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtJabatan	= $_POST['txtJabatan'];
	$txtJabatan	= str_replace("'","&acute;",$txtJabatan);
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtJabatan)=="") {
		$pesanError[] = "Data <b>Nama Jabatan</b> tidak boleh kosong !";		
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
		$kodeBaru	= buatKode("jabatan", "J");
		$mySql	= "INSERT INTO jabatan (kode_jabatan, nama_jabatan) VALUES ('$kodeBaru', '$txtJabatan')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Jabatan-Add'>";
		}
		exit;
	}	
} // Penutup POST
	
# MEMBUAT NILAI DATA PADA FORM
$dataKode		= buatKode("jabatan", "P");
$dataJabatan	= isset($_POST['txtJabatan']) ? $_POST['txtJabatan'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
<table width="100%" cellpadding="2" cellspacing="1" class="table table-dark" style="margin-top:0px;">
	<tr>
	  <td colspan="3" bgcolor="#F5F5F5"><strong>TAMBAH DATA JABATAN </strong></td>
	</tr>
	<tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td></tr>
	<tr>
	  <td><b>Nama Jabatan </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtJabatan" value="<?php echo $dataJabatan; ?>" size="80" maxlength="100" /></td>
	</tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
</form>
