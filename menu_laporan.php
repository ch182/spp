<?php
if(isset($_SESSION['SES_ADMIN'])){
?>
<ul>
    <li><a href='?open=Laporan-User' title='User' target="_self">Laporan Data User</a></li>
    <li><a href='?open=Laporan-Biaya-Sekolah' title='Biaya Sekolah' target="_self">Laporan Biaya Sekolah</a></li>
    <li><a href='?open=Laporan-Jurusan' title='Jurusan' target="_self">Laporan Data Jurusan</a></li>
	<li><a href='?open=Laporan-Pelajaran' title='Pelajaran' target="_self">Laporan Data Pelajaran</a></li>
    <li><a href='?open=Laporan-Guru' title='Guru' target="_self">Laporan Data Guru</a></li>
    <li><a href='?open=Laporan-Siswa' title='Siswa' target="_self">Laporan Data Siswa</a></li>
    <li><a href='?open=Laporan-Pembayaran-Bulan' title='Pembayaran Tahun' target="_self">Laporan Pembayaran per Bulan</a></li>
    <li><a href='?open=Laporan-Pembayaran-Tahun' title='Pembayaran Tahun' target="_self">Laporan Pembayaran per Tahun</a></li>
    <li><a href='?open=Laporan-Pembayaran-Siswa' title='Pembayaran Siswa' target="_self">Laporan Pembayaran  per Siswa</a></li>	
    <li><a href='?open=Laporan-Bayar-DKS-Tahun' title='Pembayaran DKS' target="_self">Laporan Pembayaran DKS per Tahun</a></li>
    <li><a href='?open=Laporan-Bayar-DKS-Angkatan' title='Pembayaran DKS' target="_self">Laporan Pembayaran DKS per Angkatan</a></li>
    <li><a href='?open=Laporan-Bayar-DKS-Siswa' title='Pembayaran DKS' target="_self">Laporan Pembayaran DKS per Siswa</a></li>
</ul>
<?php
}
elseif(isset($_SESSION['SES_PENGAJARAN'])){
?>
<ul>
    <li><a href='?open=Laporan-Biaya-Sekolah' title='Biaya Sekolah' target="_self">Laporan Biaya Sekolah</a></li>
    <li><a href='?open=Laporan-Jurusan' title='Jurusan' target="_self">Laporan Data Jurusan</a></li>
	<li><a href='?open=Laporan-Pelajaran' title='Pelajaran' target="_self">Laporan Data Pelajaran</a></li>
    <li><a href='?open=Laporan-Guru' title='Guru' target="_self">Laporan Data Guru</a></li>
    <li><a href='?open=Laporan-Siswa' title='Siswa' target="_self">Laporan Data Siswa</a></li>
    <li><a href='?open=Laporan-Pembayaran-Bulan' title='Pembayaran Tahun' target="_self">Laporan Pembayaran per Bulan</a></li>
    <li><a href='?open=Laporan-Pembayaran-Tahun' title='Pembayaran Tahun' target="_self">Laporan Pembayaran per Tahun</a></li>
    <li><a href='?open=Laporan-Pembayaran-Siswa' title='Pembayaran Siswa' target="_self">Laporan Pembayaran  per Siswa</a></li>
    <li><a href='?open=Laporan-Bayar-DKS-Tahun' title='Pembayaran DKS' target="_self">Laporan Pembayaran DKS per Tahun</a></li>
    <li><a href='?open=Laporan-Bayar-DKS-Angkatan' title='Pembayaran DKS' target="_self">Laporan Pembayaran DKS per Angkatan</a></li>
    <li><a href='?open=Laporan-Bayar-DKS-Siswa' title='Pembayaran DKS' target="_self">Laporan Pembayaran DKS per Siswa</a></li>
</ul>
<?php
}
else { ?>
	<ul>
	<li><a href='?open=Laporan' title='Laporan'>Laporan</a></li>	
	</ul>
<?php 
}
?>
 
