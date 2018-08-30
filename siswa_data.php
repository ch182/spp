<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

# Filter Data Nilai berdasarkan Combo yang dipilih
$filterSQL	= "";
if(isset($_POST['btnTampil'])) {
	$txtKataKunci	= $_POST['txtKataKunci'];
	$cmbJurusan		= $_POST['cmbJurusan'];
	
	if(trim($txtKataKunci)=="") {
		// jika kata kunci tidak diisi
		if($cmbJurusan=="Kosong") {
			// jika jurusan juga tidak dipilih
			$filterSQL = "";
		}
		else {
			// jika jurusan ada yang dipilih
			$filterSQL = " WHERE siswa.kode_jurusan = '$cmbJurusan'";
		}
	}
	else {
		// jika kata kunci diisi
		if($cmbJurusan=="Kosong") {
			// dan jika jurusan tidak dipilih
			$filterSQL = "WHERE nis='$txtKataKunci' OR nama_siswa LIKE '%$txtKataKunci%' ";
		}
		else {
			// dan jika jurusan dipilih 
			$filterSQL = "WHERE ( nis='$txtKataKunci' OR nama_siswa LIKE '%$txtKataKunci%' ) AND siswa.kode_jurusan = '$cmbJurusan'";
		}
	}
}
else {
	$filterSQL = "";
}

# Teks pada form
$dataKataKunci 	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';
$dataJurusan	= isset($_POST['cmbJurusan']) ? $_POST['cmbJurusan'] : '';


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT siswa.*, jurusan.nama_jurusan FROM siswa 
			LEFT JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan $filterSQL";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($pageQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="table-border">
    <tr>
      <td colspan="2" align="center"><h2><b>DATA SISWA </b></h2></td>
    </tr>
    <tr>
      <td colspan="2">

	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
	<table width="100%" border="0" cellpadding="2" cellspacing="1" class="table-list">
	<tr>
	  <td width="184"><strong>Pencarian (NIS / Nama ) </strong></td>
	  <td width="25"><b>:</b></td>
	  <td width="691"><input name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="40" maxlength="100" /></td>
	</tr>
	<tr>
      <td><b>Jurusan</b></td>
	  <td><b>:</b></td>
	  <td><select name="cmbJurusan">
        <option value="Kosong">....</option>
        <?php
		// Skrip menampilkan Jurusan pada ComboBox
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
	    <strong>
          <input name="btnTampil" type="submit" value="Tampilkan" />
        </strong></td>
		<td colspan="2" align="right"><a href="?open=Siswa-Add" target="_self"><img src="images/btn_add_data.png" height="25" border="0" /></a></td>
	  </tr>
	</table>
	</form>

	  </td>
    </tr>
    <tr>
      
    </tr>

    <tr>
	  <td colspan="2"><div class="table-responsive">
	  <table class="table table-bordered" width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td width="25" height="23" align="center" bgcolor="#999999"><strong>No</strong></td>
          <td width="100" bgcolor="#999999"><strong>Kode</strong></td>
          <td width="100" bgcolor="#999999"><strong>NIS</strong></td>
          <td width="242" bgcolor="#999999"><strong>Nama Siswa </strong></td>
          <td width="56" bgcolor="#999999"><strong>Kelamin</strong></td>
          <td width="161" bgcolor="#999999"><strong>Jurusan</strong></td>
          <td width="65" bgcolor="#999999"><strong>Angkatan</strong></td>
          <td width="42" bgcolor="#999999"><strong>Status</strong></td>
          <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
        <?php
		// Skrip menampilkan data Siswa
	$mySql = "SELECT siswa.*, jurusan.nama_jurusan FROM siswa LEFT JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan
				$filterSQL
				ORDER BY kode_siswa ASC LIMIT $mulai, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor = $mulai; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kode_siswa'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
        <tr bgcolor="<?php echo $warna; ?>">
          <td align="center"><?php echo $nomor; ?></td>
          <td><?php echo $myData['kode_siswa']; ?></td>
          <td><?php echo $myData['nis']; ?></td>
          <td><?php echo $myData['nama_siswa']; ?></td>
          <td><?php echo $myData['kelamin']; ?></td>
          <td><?php echo $myData['nama_jurusan']; ?></td>
          <td><?php echo $myData['th_angkatan']; ?></td>
          <td><?php echo $myData['status']; ?></td>
          <td width="39" align="center"><a href="?open=Siswa-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data"  onclick="return confirm('YAKIN AKAN MENGHAPUS DATA SISWA INI ... ?')">Delete</a></td>
          <td width="39" align="center"><a href="?open=Siswa-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a> </td>
          <td width="39" align="center"><a href="cetak/siswa_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
        </tr>
        <?php } ?>
      </table></div></td>
    </tr>
    <tr class="selKecil">
      <td height="22" bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jumlah; ?> </td>
      <td align="right" bgcolor="#F5F5F5"><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Siswa-Data&hal=$h'>$h</a> ";
	}
	?></td>
    </tr>
</table>
