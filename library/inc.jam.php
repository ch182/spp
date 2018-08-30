<?php
function listJam($nama, $jamaktif) {
	# Pecah Bagian Tanggal
	$jamTerpilih=substr($jamaktif,0,2);
	$menitTerpilih=substr($jamaktif,3,2);

	# Combo/ ListBox untuk Jam
	echo "<select name='cmbJam$nama' id='$nama'>";
	  for ($jam =1; $jam <= 24; $jam++) {
	  	// Dua digit
		if (strlen($jam)==1) {
			$jam = "0".$jam;
		}
		else { $jam = $jam; }

		// Terpilih
		if ($jam==$jamTerpilih) {
			$cek=" selected";
		} else { $cek = ""; }

		echo "<option value='$jam' $cek>$jam</option>";
	  }
	echo "</select>";
	echo " <b>:</b> ";
	
	# Combo/ ListBox untuk Menit
	echo "<select name='cmbMenit$nama' id='$nama'>";
	  for ($menit =0; $menit <= 60; $menit++) {
	  	// Dua digit
		if (strlen($menit)==1) {
			$menit = "0".$menit;
		}
		else { $menit = $menit; }

		// Terpilih
		if ($menit==$menitTerpilih) {
			$cek=" selected";
		} else { $cek = ""; }
		
		echo "<option value='$menit' $cek> $menit</option>";
	  }
	echo "</select>";
}
?>

