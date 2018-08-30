<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

# Filter Data Nilai berdasarkan Combo yang dipilih
$filterSQL  = "";
if(isset($_POST['btnTampil'])) {
  $txtKataKunci = $_POST['txtKataKunci'];
  $cmbJabatan   = $_POST['cmbJabatan'];
  
  if(trim($txtKataKunci)=="") {
    // jika kata kunci tidak diisi
    if($cmbJabatan=="Kosong") {
      // jika jurusan juga tidak dipilih
      $filterSQL = "";
    }
    else {
      // jika jurusan ada yang dipilih
      $filterSQL = " WHERE guru.kode_jabatan = '$cmbJabatan'";
    }
  }
  else {
    // jika kata kunci diisi
    if($cmbJurusan=="Kosong") {
      // dan jika jurusan tidak dipilih
      $filterSQL = "WHERE nip='$txtKataKunci' OR nama_guru LIKE '%$txtKataKunci%' ";
    }
    else {
      // dan jika jurusan dipilih 
      $filterSQL = "WHERE ( nip='$txtKataKunci' OR nama_guru LIKE '%$txtKataKunci%' ) AND guru.kode_jabatan = '$cmbJabatan'";
    }
  }
}
else {
  $filterSQL = "";
}

# Teks pada form
$dataKataKunci  = isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';
$dataJabatan  = isset($_POST['cmbJabatan']) ? $_POST['cmbJabatan'] : '';

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT guru.*, jabatan.nama_jabatan FROM guru
      LEFT JOIN jabatan ON guru.kode_jabatan = jabatan.kode_jabatan $filterSQL";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($pageQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td colspan="2" align="center"><h2><b>DATA GURU </b></h2></td>
  </tr>  
  <tr>
    <td colspan="2">
      
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" class="table-list">
  <tr>
  </tr>
  <tr>
    <td width="184"><strong>Pencarian (NIP / Nama ) </strong></td>
    <td width="25"><b>:</b></td>
    <td width="691"><input name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="40" maxlength="100" /></td>
  </tr>
  <tr>
      <td><b>Jabatan</b></td>
    <td><b>:</b></td>
    <td><select name="cmbJabatan">
        <option value="Kosong">....</option>
        <?php
    // Skrip menampilkan Jurusan pada ComboBox
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
      <strong>
          <input name="btnTampil" type="submit" value="Tampilkan" />
        </strong></td>
		<td colspan="2" align="right"><a href="?open=Guru-Add" target="_self"><img src="images/btn_add_data.png" height="25" border="0" /></a></td>
    </tr>
  </table>
  </form>
    </td>
  </tr>
  <tr>
    <td colspan="2">
	<div class="table-responsive">
	<table class="table table-bordered" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="26" height="23" align="center" bgcolor="#999999"><strong>No</strong></td>
        <td width="63" bgcolor="#999999"><strong>Kode</strong></td>
        <td width="102" bgcolor="#999999"><strong>NIP</strong></td>
        <td width="265" bgcolor="#999999"><strong>Nama Guru </strong></td>
        <td width="151" bgcolor="#999999"><strong>Bidang Studi </strong></td>
         <td width="151" bgcolor="#999999"><strong>Posisi </strong></td>
        <td width="80" bgcolor="#999999"><strong>Kelamin</strong></td>
        <td width="74" bgcolor="#999999"><strong>Status</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong><strong></strong></td>
      </tr>
      <?php
	  // Skrip menampilkan data Guru
	$mySql = "SELECT guru.*, jabatan.nama_jabatan FROM guru LEFT JOIN jabatan ON guru.kode_jabatan = jabatan.kode_jabatan
        $filterSQL
        ORDER BY kode_guru ASC LIMIT $mulai, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor = $mulai; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kode_guru'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kode_guru']; ?></td>
        <td><?php echo $myData['nip']; ?></td>
        <td><?php echo $myData['nama_guru']; ?></td>
        <td><?php echo $myData['bidang_studi']; ?></td>
        <td><?php echo $myData['nama_jabatan']; ?></td>
        <td><?php echo $myData['kelamin']; ?></td>
        <td><?php echo $myData['status_aktif']; ?></td>
        <td width="45" align="center"><a href="?open=Guru-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data"  onclick="return confirm('YAKIN AKAN MENGHAPUS DATA GURU INI ... ?')">Delete</a></td>
        <td width="44" align="center"><a href="?open=Guru-Edit&;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a> </td>
      </tr>
      <?php } ?>
    </table></div></td>
  </tr>
  <tr class="selKecil">
    <td height="22" bgcolor="#F5F5F5"><b>Jumlah Data :</b> <?php echo $jumlah; ?> </td>
    <td align="right" bgcolor="#F5F5F5"><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Guru-Data&hal=$h'>$h</a> ";
	}
	?></td>
  </tr>
</table>
