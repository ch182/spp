<?php
include_once "library/inc.ses_pengajaran.php";
include_once "library/inc.library.php";

# Tahun Terpilih
$dataKelas 		= isset($_POST['cmbKelas']) ? $_POST['cmbKelas'] : '';
$dataPelajaran 	= isset($_POST['cmbPelajaran']) ? $_POST['cmbPelajaran'] : '';
$dataSemester	= isset($_POST['cmbSemester']) ? $_POST['cmbSemester'] : '';

# Filter Data Nilai berdasarkan Combo yang dipilih
$filterSQL	= "";
if(isset($_POST['btnPilih'])) {
	$filterSQL = " AND nilai.kode_kelas = '$dataKelas' AND nilai.semester = '$dataSemester'";
}
else {
	$filterSQL = "";
}
?>

<h2>MEMBUAT NILAI RAPORT</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" target="_self">
<table width="450" border="0" cellpadding="2" cellspacing="1" class="table-list">
<tr>
  <th colspan="3" bgcolor="#CCCCCC"><b>FILTER </b></th>
</tr>
<tr>
  <td><b>Pilih Kelas </b></td>
  <td><b>:</b></td>
  <td><select name="cmbKelas">
    <option value="KOSONG">....</option>
    <?php
	  $dataSql = "SELECT * FROM kelas ORDER BY tahun_ajar";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataRow['kode_kelas'] == $dataKelas) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[kode_kelas]' $cek>$dataRow[kelas] | $dataRow[nama_kelas] ( $dataRow[tahun_ajar] )</option>";
	  }
	  ?>
  </select></td>
</tr>
<tr>
  <td><strong>Semester</strong></td>
  <td><b>:</b></td>
  <td><select name="cmbSemester">
    <?php
		  $pilihan	= array("1" => "Ganjil", "2" => "Genap");
          foreach ($pilihan as $isi => $info ) {
            if ($dataSemester==$isi) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$isi' $cek> $isi - $info</option>";
          }
          ?>
  </select>
    <input name="btnPilih" type="submit" value=" Pilih " /></td>
</tr>
<tr>
  <td width="112">&nbsp;</td>
  <td width="5">&nbsp;</td>
  <td width="317">&nbsp;</td>
</tr>
</table>
</form>

<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="39" height="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></th>
    <th width="80" bgcolor="#CCCCCC"><strong>Kode</strong></th>
    <th width="98" bgcolor="#CCCCCC"><strong>NIS </strong></th>
    <th width="265" bgcolor="#CCCCCC"><strong>Nama Siswa </strong></th>
    <th width="120" bgcolor="#CCCCCC"><strong>Angkatan</strong></th>
    <th width="67" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></th>
  </tr>
  <?php
  	// Menampilkan Semua data Siswa dengan Filter per Tahun
	$mySql = "SELECT kelas_siswa.*, nilai.semester, siswa.nis, siswa.nama_siswa, siswa.th_angkatan 
			FROM nilai, kelas, kelas_siswa
			LEFT JOIN siswa ON kelas_siswa.kode_siswa = siswa.kode_siswa
			WHERE kelas.kode_kelas = kelas_siswa.kode_kelas AND kelas.kode_kelas = nilai.kode_kelas
			$filterSQL
			GROUP BY kode_siswa ORDER BY kode_siswa ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$kodeSiswa 	= $myData['kode_siswa'];
		$kodeKelas 	= $myData['kode_kelas'];
		$semester 	= $myData['semester'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kode_siswa']; ?></td>
    <td><?php echo $myData['nis']; ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td><?php echo $myData['th_angkatan']; ?></td>
    <td align="center" bgcolor="<?php echo $warna; ?>"><a href="cetak/raport_siswa.php?kodeSiswa=<?php echo $kodeSiswa; ?>&kodeKelas=<?php echo $kodeKelas; ?>&semester=<?php echo $semester; ?>" target="_blank">Raport</a></td>
  </tr>
  <?php } ?>
</table>
