<?php
if($_GET) {
	switch($_GET['open']){				
		case '' :				
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";		break;

		case 'Login' :				
			if(!file_exists ("login.php")) die ("File program tidak ditemukan !"); 
			include "login.php";	break;
			
		case 'Login-Validasi' :				
			if(!file_exists ("login_validasi.php")) die ("File program tidak ditemukan !"); 
			include "login_validasi.php";		break;
			
		case 'Logout' :				
			if(!file_exists ("login_out.php")) die ("File program tidak ditemukan !"); 
			include "login_out.php";		break;

		# USER LOGIN
		case 'User-Data' :				
			if(!file_exists ("user_data.php")) die ("File program tidak ditemukan !"); 
			include "user_data.php";	 break;		
		case 'User-Add' :				
			if(!file_exists ("user_add.php")) die ("File program tidak ditemukan !"); 
			include "user_add.php";	 break;		
		case 'User-Edit' :				
			if(!file_exists ("user_edit.php")) die ("File program tidak ditemukan !"); 
			include "user_edit.php"; break;	
		case 'User-Delete' :				
			if(!file_exists ("user_delete.php")) die ("File program tidak ditemukan !"); 
			include "user_delete.php"; break;	
			
		# DATA BIAYA
		case 'Biaya-Data' :	
			if(!file_exists ("biaya_data.php")) die ("File program tidak ditemukan !"); 
			include "biaya_data.php";	 break;		
		case 'Biaya-Add' :				
			if(!file_exists ("biaya_add.php")) die ("File program tidak ditemukan !"); 
			include "biaya_add.php";	 break;		
		case 'Biaya-Edit' :				
			if(!file_exists ("biaya_edit.php")) die ("File program tidak ditemukan !"); 
			include "biaya_edit.php"; break;	
		case 'Biaya-Delete' :				
			if(!file_exists ("biaya_delete.php")) die ("File program tidak ditemukan !"); 
			include "biaya_delete.php"; break;	
			
		# DATA JURUSAN
		case 'Jurusan-Data' :	
			if(!file_exists ("jurusan_data.php")) die ("File program tidak ditemukan !"); 
			include "jurusan_data.php";	 break;		
		case 'Jurusan-Add' :				
			if(!file_exists ("jurusan_add.php")) die ("File program tidak ditemukan !"); 
			include "jurusan_add.php";	 break;		
		case 'Jurusan-Edit' :				
			if(!file_exists ("jurusan_edit.php")) die ("File program tidak ditemukan !"); 
			include "jurusan_edit.php"; break;	
		case 'Jurusan-Delete' :				
			if(!file_exists ("jurusan_delete.php")) die ("File program tidak ditemukan !"); 
			include "jurusan_delete.php"; break;	
			
		# DATA PELAJARAN
		case 'Pelajaran-Data' :	
			if(!file_exists ("pelajaran_data.php")) die ("File program tidak ditemukan !"); 
			include "pelajaran_data.php";	 break;		
		case 'Pelajaran-Add' :				
			if(!file_exists ("pelajaran_add.php")) die ("File program tidak ditemukan !"); 
			include "pelajaran_add.php";	 break;		
		case 'Pelajaran-Edit' :				
			if(!file_exists ("pelajaran_edit.php")) die ("File program tidak ditemukan !"); 
			include "pelajaran_edit.php"; break;	
		case 'Pelajaran-Delete' :				
			if(!file_exists ("pelajaran_delete.php")) die ("File program tidak ditemukan !"); 
			include "pelajaran_delete.php"; break;	

		# DATA GURU
		case 'Guru-Data' :	
			if(!file_exists ("guru_data.php")) die ("File program tidak ditemukan !"); 
			include "guru_data.php";	 break;		
		case 'Guru-Add' :				
			if(!file_exists ("guru_add.php")) die ("File program tidak ditemukan !"); 
			include "guru_add.php";	 break;		
		case 'Guru-Edit' :				
			if(!file_exists ("guru_edit.php")) die ("File program tidak ditemukan !"); 
			include "guru_edit.php"; break;	
		case 'Guru-Delete' :				
			if(!file_exists ("guru_delete.php")) die ("File program tidak ditemukan !"); 
			include "guru_delete.php"; break;	

								
		# DATA SISWA
		case 'Siswa-Data' :				
			if(!file_exists ("siswa_data.php")) die ("File program tidak ditemukan !"); 
			include "siswa_data.php";	 break;		
		case 'Siswa-Add' :				
			if(!file_exists ("siswa_add.php")) die ("File program tidak ditemukan !"); 
			include "siswa_add.php";	 break;		
		case 'Siswa-Edit' :				
			if(!file_exists ("siswa_edit.php")) die ("File program tidak ditemukan !"); 
			include "siswa_edit.php"; break;	
		case 'Siswa-Delete' :
			if(!file_exists ("siswa_delete.php")) die ("File program tidak ditemukan !"); 
			include "siswa_delete.php"; break;		

		# DATA JABATAN
		case 'Jabatan-Data' :	
			if(!file_exists ("jabatan_data.php")) die ("File program tidak ditemukan !"); 
			include "jabatan_data.php";	 break;		
		case 'Jabatan-Add' :				
			if(!file_exists ("jabatan_add.php")) die ("File program tidak ditemukan !"); 
			include "jabatan_add.php";	 break;		
		case 'Jabatan-Edit' :				
			if(!file_exists ("jabatan_edit.php")) die ("File program tidak ditemukan !"); 
			include "jabatan_edit.php"; break;	
		case 'Jabatan-Delete' :				
			if(!file_exists ("jabatan_delete.php")) die ("File program tidak ditemukan !"); 
			include "jabatan_delete.php"; break;	
			
				
		# DATA PEMBAYARAN DSP dan SPP
		// Sumbangan Pendanaan Pendidikan (SPP)
		case 'Pembayaran-Data' :				
			if(!file_exists ("pembayaran_data.php")) die ("File program tidak ditemukan !"); 
			include "pembayaran_data.php";	 break;		
		case 'Pembayaran-Add' :				
			if(!file_exists ("pembayaran_add.php")) die ("File program tidak ditemukan !"); 
			include "pembayaran_add.php";	 break;		
		case 'Pembayaran-Edit' :				
			if(!file_exists ("pembayaran_edit.php")) die ("File program tidak ditemukan !"); 
			include "pembayaran_edit.php";	 break;		
		case 'Pembayaran-Delete' :				
			if(!file_exists ("pembayaran_delete.php")) die ("File program tidak ditemukan !"); 
			include "pembayaran_delete.php";	 break;		

		# DATA PEMBAYARAN DKS
		// DKS = Dana Kegiatan Siswa
		case 'Pembayaran-DKS-Data' :				
			if(!file_exists ("pembayaran_dks_data.php")) die ("File program tidak ditemukan !"); 
			include "pembayaran_dks_data.php";	 break;		
		case 'Pembayaran-DKS-Add' :				
			if(!file_exists ("pembayaran_dks_add.php")) die ("File program tidak ditemukan !"); 
			include "pembayaran_dks_add.php";	 break;		
		case 'Pembayaran-DKS-Edit' :				
			if(!file_exists ("pembayaran_dks_edit.php")) die ("File program tidak ditemukan !"); 
			include "pembayaran_dks_edit.php";	 break;		
		case 'Pembayaran-DKS-Delete' :				
			if(!file_exists ("pembayaran_dks_delete.php")) die ("File program tidak ditemukan !"); 
			include "pembayaran_dks_delete.php";	 break;		

		# MEMBUAT RAPORT
		
		# MASTER DATA
		case 'Laporan' :	
			if(!file_exists ("menu_laporan.php")) die ("File program tidak ditemukan !"); 
				include "menu_laporan.php";	break;						
		
			# INFORMASI DAN LAPORAN
			case 'Laporan-User' :				
				if(!file_exists ("laporan_user.php")) die ("File program tidak ditemukan !"); 
				include "laporan_user.php"; break;		
					
			case 'Laporan-Biaya-Sekolah' :				
				if(!file_exists ("laporan_biaya_sekolah.php")) die ("File program tidak ditemukan !"); 
				include "laporan_biaya_sekolah.php"; break;	
					
			case 'Laporan-Jurusan' :				
				if(!file_exists ("laporan_jurusan.php")) die ("File program tidak ditemukan !"); 
				include "laporan_jurusan.php"; break;	
					
			case 'Laporan-Pelajaran' :				
				if(!file_exists ("laporan_pelajaran.php")) die ("File program tidak ditemukan !"); 
				include "laporan_pelajaran.php"; break;	
					
			case 'Laporan-Guru' :				
				if(!file_exists ("laporan_guru.php")) die ("File program tidak ditemukan !"); 
				include "laporan_guru.php"; break;	
					
					
			case 'Laporan-Siswa' :				
				if(!file_exists ("laporan_siswa.php")) die ("File program tidak ditemukan !"); 
				include "laporan_siswa.php"; break;	
				
			
			// LAPORAN PEMBAYARAN SPP	
			case 'Laporan-Pembayaran-Bulan' :				
				if(!file_exists ("laporan_pembayaran_bulan.php")) die ("File program tidak ditemukan !"); 
				include "laporan_pembayaran_bulan.php"; break;	
			
			case 'Laporan-Pembayaran-Tahun' :				
				if(!file_exists ("laporan_pembayaran_tahun.php")) die ("File program tidak ditemukan !"); 
				include "laporan_pembayaran_tahun.php"; break;	
			
			case 'Laporan-Pembayaran-Bulan' :				
				if(!file_exists ("laporan_pembayaran_bulan.php")) die ("File program tidak ditemukan !"); 
				include "laporan_pembayaran_bulan.php"; break;	
			
			case 'Laporan-Pembayaran-Siswa' :				
				if(!file_exists ("laporan_pembayaran_siswa.php")) die ("File program tidak ditemukan !"); 
				include "laporan_pembayaran_siswa.php"; break;			
					
			case 'Laporan-Bayar-Siswa-Rincian' :				
				if(!file_exists ("laporan_bayar_siswa_rincian.php")) die ("File program tidak ditemukan !"); 
				include "laporan_bayar_siswa_rincian.php"; break;	
			
			// LAPORAN PEMBAYARAN DKS	
			case 'Laporan-Bayar-DKS-Tahun' :				
				if(!file_exists ("laporan_bayar_dks_tahun.php")) die ("File program tidak ditemukan !"); 
				include "laporan_bayar_dks_tahun.php"; break;	
					
			case 'Laporan-Bayar-DKS-Angkatan' :				
				if(!file_exists ("laporan_bayar_dks_angkatan.php")) die ("File program tidak ditemukan !"); 
				include "laporan_bayar_dks_angkatan.php"; break;		
					
			case 'Laporan-Bayar-DKS-Siswa' :				
				if(!file_exists ("laporan_bayar_dks_siswa.php")) die ("File program tidak ditemukan !"); 
				include "laporan_bayar_dks_siswa.php"; break;	
					
			case 'Laporan-Bayar-DKS-Siswa-Rincian' :				
				if(!file_exists ("laporan_bayar_dks_siswa_rincian.php")) die ("File program tidak ditemukan !"); 
				include "laporan_bayar_dks_siswa_rincian.php"; break;		
	
		default:
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";						
		break;
	}
}
else {
	if(!file_exists ("main.php")) die ("File program tidak ditemukan !"); 
			include "main.php";
}
?>