<?php
if(isset($_SESSION['SES_ADMIN'])){
?>
	<ul>
	<li><a href='?open' title='Halaman Utama'>Home</a></li>
	<li><a href='?open=User-Data' title='User'> Data User</a></li>
	<li><a href='?open=Biaya-Data' title='Biaya' target="_self"> Data Biaya Sekolah</a></li>
	<li><a href='?open=Jurusan-Data' title='Jurusan' target="_self"> Data Jurusan</a></li>
	<li><a href='?open=Pelajaran-Data' title='Pelajaran' target="_self"> Data Pelajaran</a></li>
	<li><a href='?open=Guru-Data' title='Guru'> Data Guru</a></li>
	<li><a href='?open=Siswa-Data' title='Siswa'> Data Siswa</a></li>
	<li><a href='?open=Jabatan-Data' title='Nilai'> Jabatan</a></li>
	<li><a href='?open=Pembayaran-Data' title='Pembayaran'> Pembayaran (DSP & SPP)</a></li>
	<li><a href='?open=Pembayaran-DKS-Data' title='Bayar DKS'> Pembayaran DKS</a></li>
	<li><a href='?open=Laporan' title='Laporan'> Laporan</a></li>
	<li><a href='?open=Logout' title='Logout (Exit)'>Logout</a></li>
	</ul>
<?php
}
elseif(isset($_SESSION['SES_PENGAJARAN'])){
?>
	<ul>
	<li><a href='?open' title='Halaman Utama'>Home</a></li>
	<li><a href='?open=Biaya-Data' title='Biaya' target="_self"> Data Biaya Sekolah</a></li>
	<li><a href='?open=Jurusan-Data' title='Jurusan' target="_self"> Data Jurusan</a></li>
	<li><a href='?open=Pelajaran-Data' title='Pelajaran' target="_self"> Data Pelajaran</a></li>
	<li><a href='?open=Guru-Data' title='Guru'> Data Guru</a></li>
	<li><a href='?open=Siswa-Data' title='Siswa'> Data Siswa</a></li>
	<li><a href='?open=Pembayaran-Data' title='Pembayaran'> Pembayaran (DSP & SPP)</a></li>
	<li><a href='?open=Pembayaran-DKS-Data' title='Bayar DKS'> Pembayaran DKS</a></li>
	<li><a href='?open=Laporan' title='Laporan'> Laporan</a></li>
	<li><a href='?open=Logout' title='Logout (Exit)'>Logout</a></li>
	</ul>
<?php
}
elseif(isset($_SESSION['SES_KASIR'])){
?>
	<ul>
	<li><a href='?open' title='Halaman Utama'>Home</a></li>
	<li><a href='?open=Pembayaran-Data' title='Pembayaran'> Pembayaran (DSP & SPP)</a></li>
	<li><a href='?open=Pembayaran-DKS-Data' title='Bayar DKS'> Pembayaran DKS</a></li>
	<li><a href='?open=Logout' title='Logout (Exit)'>Logout</a></li>
	</ul>
<?php
}
else { ?>
	<ul>
	<button class="btn btn-light btn-lg" href="#signup" data-toggle="modal" data-target=".log-sign">Sign In/Register</button>	
	</ul>
<?php 
}
?>