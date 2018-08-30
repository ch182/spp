<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtPelajaran	= $_POST['txtPelajaran'];
	$txtPelajaran	= str_replace("'","&acute;",$txtPelajaran);
	$txtKeterangan	= $_POST['txtKeterangan'];
	$cmbJurusan		= $_POST['cmbJurusan'];

	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtPelajaran)=="") {
		$pesanError[] = "Data <b>Nama Pelajaran</b> tidak boleh kosong !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";	
	}
	if (trim($cmbJurusan)=="Kosong") {
		$pesanError[] = "Data <b>Jurusan</b> tidak boleh kosong !";	
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
		$kodeBaru	= buatKode("pelajaran", "P");
		$mySql	= "INSERT INTO pelajaran (kode_pelajaran, nama_pelajaran, keterangan, kode_jurusan) VALUES ('$kodeBaru', '$txtPelajaran', '$txtKeterangan', '$cmbJurusan')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Pelajaran-Add'>";
		}
		exit;
	}	
} // Penutup POST
	
# MEMBUAT NILAI DATA PADA FORM
$dataKode		= buatKode("pelajaran", "P");
$dataPelajaran	= isset($_POST['txtPelajaran']) ? $_POST['txtPelajaran'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataJurusan	= isset($_POST['cmbJurusan']) ? $_POST['cmbJurusan'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
<table width="100%" cellpadding="2" cellspacing="1" class="table table-dark" style="margin-top:0px;">
	<tr>
	  <td colspan="3" bgcolor="#F5F5F5"><strong>TAMBAH DATA PELAJARAN </strong></td>
	</tr>
	<tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td></tr>
	<tr>
	  <td><b>Nama Pelajaran </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtPelajaran" value="<?php echo $dataPelajaran; ?>" size="80" maxlength="100" /></td>
	</tr>
	<tr>
      <td><b>Keterangan</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
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
	  	echo "<option value='$dataRow[kode_jurusan]' $cek> $dataRow[nama_jurusan] - $dataRow[keterangan]</option>";
	  }
	  ?>
      </select></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
</form>
