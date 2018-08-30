-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2018 at 07:29 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sia_42db`
--

-- --------------------------------------------------------

--
-- Table structure for table `biaya_sekolah`
--

CREATE TABLE IF NOT EXISTS `biaya_sekolah` (
  `kode_biaya` char(5) NOT NULL,
  `kode_jurusan` char(4) NOT NULL,
  `th_angkatan` char(4) NOT NULL,
  `keterangan` varchar(60) NOT NULL,
  `biaya_dsp` int(12) NOT NULL,
  `biaya_spp` int(12) NOT NULL,
  `biaya_dks_putra` int(12) NOT NULL,
  `biaya_dks_putri` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `biaya_sekolah`
--

INSERT INTO `biaya_sekolah` (`kode_biaya`, `kode_jurusan`, `th_angkatan`, `keterangan`, `biaya_dsp`, `biaya_spp`, `biaya_dks_putra`, `biaya_dks_putri`) VALUES
('BS001', 'J001', '2017', 'Reguler', 200000, 250000, 5600000, 5800000),
('BS002', 'J002', '2017', 'Reguler', 200000, 270000, 5700000, 5900000),
('BS003', 'J003', '2017', 'Reguler', 200000, 250000, 5700000, 5800000),
('BS004', 'J004', '2017', 'Reguler', 200000, 280000, 5800000, 5900000),
('BS005', 'J005', '2017', 'Reguler', 200000, 250000, 5600000, 5800000);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE IF NOT EXISTS `guru` (
  `kode_guru` char(5) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `kelamin` varchar(10) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `pendidikan` varchar(100) NOT NULL,
  `bidang_studi` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `status_aktif` enum('Aktif','Tidak') NOT NULL,
  `kode_jabatan` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`kode_guru`, `nip`, `nama_guru`, `kelamin`, `alamat`, `no_telepon`, `pendidikan`, `bidang_studi`, `foto`, `status_aktif`, `kode_jabatan`) VALUES
('G0001', '201200001', 'Indah Indriyanna', 'Perempuan', 'Jl. Janti, Agen JNE, Karang Jambe, Yogyakarta', '081911111111', 'S1 - STMIK AMIKOM Yogyakarta', 'Teknologi Informasi Komputer (TIK)', 'G0001.indah2.jpg', 'Aktif', '0'),
('G0002', '201200002', 'Sulistiyowati', 'Perempuan', 'Jl. Suhada, Labuhan Ratu 1, Way Jepara, Lampung Timur 2', '08522211100011', 'S2 Teknik Komputer UGM', 'Ilmu Komputer', '', 'Aktif', '0'),
('G0003', '201200003', 'Juwanto', 'Laki-laki', 'Jl. Manggarawan, Labuhan Ratu 5 Way Jepara', '0819111122223', 'S1 Bahasa Inggris DCC Bandar Lampung', 'Bahasa Inggris', '', 'Aktif', '0'),
('G0004', '201200004', 'Nano Hendrawan', 'Laki-laki', 'Jl. Margahayu, Labuhan Ratu Baru, Way Jepara, Lampung Timur', '08191111111222', 'S1 Bahasa Inggris DCC Bandar Lampung', 'Bahasa Inggris', '', 'Aktif', '0'),
('G0005', '201200005', 'Fitria Prasetiawati', 'Perempuan', 'Jl. Parangtritis, 111, Bantulan, Yogyakarta', '08191818181818', 'S1 Ilmu Gizi Univ Respati Yogyakarta', 'Ilmu Gizi/ Kesehatan', '', 'Aktif', '0'),
('G0006', '201200006', 'Sugeng Fitriyadi', 'Laki-laki', 'Jl. Simpang H, Way Jepara, Lampung Timur', '08191111123', 'Sarjana Ekonomi (SE) UGM Yogyakarta', 'Ekonomi', '', 'Aktif', '0'),
('G0007', '201200007', 'Suyono', 'Laki-laki', 'Jl. Raya Way Jepara, Depan PU, Lampung Timur', '02152211345', 'S2 Manajemen UNILA', 'Geografi dan Manajemen', '', 'Aktif', '0'),
('G0008', '201200008', 'Armando', 'Laki-laki', 'Jl. Srimenanti, Way Jepara, Lampung Timur', '08154332211', 'S1 Matematika UBL', 'Matematika', '', 'Aktif', '0'),
('G0009', '201200009', 'Aliminudin, MM', 'Laki-laki', 'Jl. Minang Rejo, Labuhan Ratu Satu, Way Jepara, Lampung Timur', '021823444555', 'S2 Manajemen UNILA', 'Manajemen dan Ekonomi', '', 'Aktif', '0'),
('G0010', '201200010', 'Iswanto, MM', 'Laki-laki', 'Jl. Margayu, Labuhan Ratu Baru, Way Jepara, Lampung Timur', '02153324445', 'S2 Manajemen UNILA', 'Bahasa Indonesia dan Manajemen', '', 'Aktif', '0'),
('G0011', '123456', 'AAAAA', 'Perempuan', 'SASNJKAS', '989796876786', 'S1', 'AAAAA', '', 'Aktif', 'J001');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE IF NOT EXISTS `jabatan` (
  `kode_jabatan` char(4) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`kode_jabatan`, `nama_jabatan`) VALUES
('J001', 'STAFF'),
('J002', 'KEPALA SEKOLAH');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE IF NOT EXISTS `jurusan` (
  `kode_jurusan` char(4) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`kode_jurusan`, `nama_jurusan`, `keterangan`) VALUES
('J001', 'Akuntansi', 'Akuntansi'),
('J002', 'Adm. Perkantoran', 'Administrasi Perkantoran'),
('J003', 'Pemasaran', 'Pemasaran'),
('J004', 'Multimedia', 'Multimedia'),
('J005', 'RPL', 'Rekayasa Perangkat Lunak');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE IF NOT EXISTS `kelas` (
  `kode_kelas` char(4) NOT NULL,
  `kode_jurusan` char(4) NOT NULL,
  `kode_guru` char(5) NOT NULL,
  `tahun_ajar` varchar(12) NOT NULL,
  `kelas` char(2) NOT NULL,
  `nama_kelas` varchar(20) NOT NULL,
  `status_aktif` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`kode_kelas`, `kode_jurusan`, `kode_guru`, `tahun_ajar`, `kelas`, `nama_kelas`, `status_aktif`) VALUES
('K001', 'J001', 'G0001', '2017/2018', 'X', 'Kelas A', 'Aktif'),
('K002', 'J001', 'G0002', '2017/2018', 'X', 'Kelas B', 'Aktif'),
('K003', 'J002', 'G0003', '2017/2018', 'X', 'Kelas A', 'Aktif'),
('K004', 'J002', 'G0004', '2017/2018', 'X', 'Kelas B', 'Aktif'),
('K005', 'J003', 'G0005', '2017/2018', 'X', 'Kelas A', 'Aktif'),
('K006', 'J003', 'G0006', '2017/2018', 'X', 'Kelas B', 'Aktif'),
('K007', 'J004', 'G0007', '2017/2018', 'X', 'Kelas A', 'Aktif'),
('K008', 'J004', 'G0008', '2017/2018', 'X', 'Kelas B', 'Aktif'),
('K009', 'J005', 'G0009', '2017/2018', 'X', 'Kelas A', 'Aktif'),
('K010', 'J005', 'G0010', '2017/2018', 'X', 'Kelas B', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_siswa`
--

CREATE TABLE IF NOT EXISTS `kelas_siswa` (
`id` int(5) NOT NULL,
  `kode_kelas` char(4) NOT NULL,
  `kode_siswa` char(5) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

--
-- Dumping data for table `kelas_siswa`
--

INSERT INTO `kelas_siswa` (`id`, `kode_kelas`, `kode_siswa`) VALUES
(1, 'K001', 'S0001'),
(2, 'K001', 'S0002'),
(3, 'K001', 'S0003'),
(4, 'K001', 'S0004'),
(5, 'K001', 'S0006'),
(18, 'K001', 'S0014'),
(17, 'K001', 'S0013'),
(16, 'K001', 'S0011'),
(15, 'K001', 'S0010'),
(14, 'K001', 'S0009'),
(19, 'K002', 'S0005'),
(20, 'K002', 'S0007'),
(21, 'K002', 'S0008'),
(22, 'K002', 'S0012'),
(23, 'K002', 'S0015'),
(24, 'K002', 'S0016'),
(25, 'K002', 'S0017'),
(26, 'K002', 'S0018'),
(27, 'K002', 'S0019'),
(28, 'K002', 'S0020'),
(29, 'K003', 'S0021'),
(30, 'K003', 'S0022'),
(31, 'K003', 'S0023'),
(32, 'K003', 'S0024'),
(33, 'K003', 'S0025'),
(34, 'K003', 'S0031'),
(35, 'K003', 'S0032'),
(36, 'K003', 'S0033'),
(37, 'K003', 'S0034'),
(38, 'K003', 'S0035'),
(39, 'K004', 'S0026'),
(40, 'K004', 'S0027'),
(41, 'K004', 'S0028'),
(42, 'K004', 'S0029'),
(43, 'K004', 'S0030'),
(44, 'K004', 'S0036'),
(45, 'K004', 'S0037'),
(46, 'K004', 'S0038'),
(47, 'K004', 'S0039'),
(48, 'K004', 'S0040'),
(49, 'K005', 'S0041'),
(50, 'K005', 'S0042'),
(51, 'K005', 'S0043'),
(52, 'K005', 'S0044'),
(53, 'K005', 'S0045'),
(54, 'K005', 'S0046'),
(55, 'K005', 'S0047'),
(56, 'K005', 'S0048'),
(57, 'K005', 'S0049'),
(58, 'K005', 'S0050'),
(59, 'K006', 'S0051'),
(60, 'K006', 'S0052'),
(61, 'K006', 'S0053'),
(62, 'K006', 'S0054'),
(63, 'K006', 'S0055'),
(64, 'K006', 'S0056'),
(65, 'K006', 'S0057'),
(66, 'K006', 'S0058'),
(67, 'K006', 'S0059'),
(68, 'K006', 'S0060'),
(69, 'K007', 'S0061'),
(70, 'K007', 'S0063'),
(71, 'K007', 'S0065'),
(72, 'K007', 'S0067'),
(73, 'K007', 'S0068'),
(74, 'K007', 'S0071'),
(75, 'K007', 'S0074'),
(76, 'K007', 'S0077'),
(77, 'K007', 'S0078'),
(78, 'K007', 'S0079'),
(79, 'K008', 'S0062'),
(80, 'K008', 'S0064'),
(81, 'K008', 'S0066'),
(82, 'K008', 'S0069'),
(83, 'K008', 'S0070'),
(84, 'K008', 'S0072'),
(85, 'K008', 'S0073'),
(86, 'K008', 'S0075'),
(87, 'K008', 'S0076'),
(88, 'K008', 'S0080'),
(89, 'K009', 'S0081'),
(90, 'K009', 'S0082'),
(91, 'K009', 'S0083'),
(92, 'K009', 'S0084'),
(93, 'K009', 'S0085'),
(94, 'K009', 'S0086'),
(95, 'K009', 'S0087'),
(96, 'K009', 'S0088'),
(97, 'K009', 'S0089'),
(98, 'K010', 'S0090'),
(99, 'K010', 'S0091'),
(100, 'K010', 'S0092'),
(101, 'K010', 'S0093'),
(102, 'K010', 'S0095'),
(103, 'K010', 'S0096'),
(104, 'K010', 'S0097'),
(105, 'K010', 'S0098'),
(106, 'K010', 'S0099'),
(107, 'K010', 'S0100');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE IF NOT EXISTS `nilai` (
`id` int(5) NOT NULL,
  `semester` int(2) NOT NULL,
  `kode_pelajaran` char(4) NOT NULL,
  `kode_guru` char(5) NOT NULL,
  `kode_kelas` char(4) NOT NULL,
  `kode_siswa` char(5) NOT NULL,
  `nilai_tugas1` int(4) NOT NULL,
  `nilai_tugas2` int(4) NOT NULL,
  `nilai_uts` int(4) NOT NULL,
  `nilai_uas` int(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `semester`, `kode_pelajaran`, `kode_guru`, `kode_kelas`, `kode_siswa`, `nilai_tugas1`, `nilai_tugas2`, `nilai_uts`, `nilai_uas`, `keterangan`) VALUES
(1, 1, 'P001', 'G0001', 'K001', 'S0001', 74, 75, 80, 85, 'lebih giat belajar'),
(3, 1, 'P001', 'G0002', 'K001', 'S0002', 75, 60, 80, 80, 'tingkatkan belajarnya'),
(4, 1, 'P001', 'G0003', 'K001', 'S0003', 70, 60, 75, 80, 'tingkatkan belajarnya'),
(5, 1, 'P001', 'G0004', 'K001', 'S0004', 75, 80, 75, 80, 'tingkatkan belajarnya'),
(6, 1, 'P001', 'G0005', 'K001', 'S0006', 68, 70, 85, 80, 'tingkatkan belajarnya terus'),
(7, 1, 'P001', 'G0001', 'K002', 'S0007', 70, 70, 75, 79, 'belajar terus'),
(8, 1, 'P001', 'G0002', 'K002', 'S0010', 78, 80, 75, 85, 'belajar terus'),
(9, 1, 'P001', 'G0002', 'K002', 'S0009', 78, 80, 75, 80, 'belajar terus ya'),
(10, 1, 'P001', 'G0002', 'K002', 'S0008', 85, 80, 85, 90, 'pertahankan belajarmu'),
(11, 1, 'P001', 'G0002', 'K002', 'S0005', 75, 75, 78, 80, 'kurang rajib belajar ya'),
(12, 1, 'P003', 'G0010', 'K001', 'S0006', 80, 85, 85, 90, 'pertahankan prestasimu'),
(13, 1, 'P003', 'G0010', 'K001', 'S0004', 70, 75, 70, 75, 'harus terus belajar'),
(14, 1, 'P003', 'G0010', 'K001', 'S0001', 75, 80, 80, 85, 'harus terus belajar'),
(15, 1, 'P003', 'G0010', 'K001', 'S0003', 85, 80, 80, 85, 'harus terus belajar'),
(16, 1, 'P003', 'G0010', 'K001', 'S0002', 75, 70, 80, 50, 'harus terus belajar'),
(17, 1, 'P002', 'G0003', 'K001', 'S0006', 78, 75, 80, 80, 'harus terus belajar'),
(18, 1, 'P002', 'G0003', 'K001', 'S0004', 80, 85, 84, 85, 'tingkatkan belajarnya'),
(19, 1, 'P002', 'G0003', 'K001', 'S0001', 85, 88, 86, 85, 'tingkatkan belajarnya'),
(20, 1, 'P002', 'G0003', 'K001', 'S0003', 85, 80, 85, 80, 'tingkatkan belajarnya'),
(21, 1, 'P002', 'G0003', 'K001', 'S0002', 85, 80, 85, 80, 'tingkatkan belajarnya'),
(22, 1, 'P002', 'G0003', 'K002', 'S0007', 75, 80, 85, 80, 'tingkatkan belajarnya'),
(23, 1, 'P002', 'G0003', 'K002', 'S0010', 78, 82, 83, 87, 'pertahankan prestasimu'),
(24, 1, 'P002', 'G0003', 'K002', 'S0008', 80, 85, 85, 90, 'pertahankan prestasimu'),
(25, 1, 'P002', 'G0003', 'K002', 'S0009', 70, 75, 75, 80, 'tingkatkan belajar'),
(26, 1, 'P002', 'G0003', 'K002', 'S0005', 75, 77, 85, 80, 'tingkatkan belajar'),
(27, 1, 'P003', 'G0003', 'K002', 'S0007', 85, 85, 85, 80, 'pertahankan prestasimu'),
(28, 1, 'P003', 'G0003', 'K002', 'S0010', 80, 85, 80, 80, 'pertahankan prestasimu'),
(29, 1, 'P003', 'G0003', 'K002', 'S0008', 85, 85, 85, 85, 'pertahankan prestasimu'),
(30, 1, 'P003', 'G0003', 'K002', 'S0009', 80, 75, 75, 85, 'tingkatkan belajarnya'),
(31, 1, 'P003', 'G0003', 'K002', 'S0005', 80, 85, 85, 85, 'pertahankan prestasimu'),
(32, 1, 'P003', 'G0010', 'K001', 'S0010', 80, 75, 60, 80, 'Tingkatkan belajarnya'),
(33, 1, 'P003', 'G0010', 'K001', 'S0013', 85, 78, 65, 80, 'Tingkatkan belajarnya');

-- --------------------------------------------------------

--
-- Table structure for table `pelajaran`
--

CREATE TABLE IF NOT EXISTS `pelajaran` (
  `kode_pelajaran` char(4) NOT NULL,
  `nama_pelajaran` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kode_jurusan` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelajaran`
--

INSERT INTO `pelajaran` (`kode_pelajaran`, `nama_pelajaran`, `keterangan`, `kode_jurusan`) VALUES
('P001', 'Pendidikan Agama dan Budi Pekerti', 'Wajib', 'J001'),
('P002', 'Pendidikan Pancasila dan Kewarganegaraan', 'Wajib', 'J001'),
('P003', 'Bahasa Indonesia', 'Wajib', 'J001'),
('P004', 'Matematika', 'Wajib', 'J001'),
('P005', 'Sejarah Indonesia', 'Wajib', 'J001'),
('P006', 'Bahasa Inggris', 'Wajib', 'J001'),
('P007', 'Seni Budaya', 'Wajib', 'J001'),
('P008', 'Prakarya dan Kewirausahaan', 'Wajib', 'J001'),
('P009', 'Pendidikan Jasmani, Olah Raga & Kesehatan', 'Wajib', 'J001'),
('P010', 'Bahasa dan Sastra Daerah', 'Wajib', 'J001'),
('P011', 'Pengantar Ekonomi dan Bisnis', 'C1. Dasar Bidang Keahlian', 'J001'),
('P012', 'Pengantar Administrasi Perkantoran', 'C1. Dasar Bidang Keahlian', 'J001'),
('P013', 'Pengantar Akuntansi', 'C1. Dasar Bidang Keahlian', 'J001'),
('P014', 'Pengelolaan Dokumen transaksi', 'C2. Dasar Program Keahlian', 'J001'),
('P015', 'Siklus Akuntansi (Perusahaan Jasa)', 'C2. Dasar Program Keahlian', 'J001'),
('P016', 'Pengelolaan Kas', 'C2. Dasar Program Keahlian', 'J001'),
('P017', 'Simulasi Digital ', 'C2. Dasar Program Keahlian', 'J001'),
('P018', 'Akuntansi Perusahaan dagang', 'C3.  Paket Keahlian', 'J001'),
('P019', 'Akuntansi Perusahaan ', 'C3.  Paket Keahlian', 'J001'),
('P020', 'Komputer Akuntansi + MYOB', 'C3.  Paket Keahlian', 'J001'),
('P021', 'Akuntansi Perusahaan Manufaktur', 'C3.  Paket Keahlian', 'J001'),
('P022', 'Administrasi Pajak', 'C3.  Paket Keahlian', 'J001'),
('P023', 'Bahasa Jepang', 'D.  Muatan Lokal', 'J001'),
('P024', 'Bahasa Jepang', 'D.  Muatan Lokal', 'J001'),
('P025', 'PLH', 'D.  Muatan Lokal', 'J001'),
('P026', 'BP/BK', 'D.  Muatan Lokal', 'J001'),
('P027', 'Pendidikan Agama dan Budi Pekerti', 'Wajib', 'J002'),
('P028', 'Pendidikan Pancasila dan Kewarganegaraan', 'Wajib', 'J002'),
('P029', 'Bahasa Indonesia', 'Wajib', 'J002'),
('P030', 'Matematika', 'Wajib', 'J002'),
('P031', 'Sejarah Indonesia', 'Wajib', 'J002'),
('P032', 'Bahasa Inggris', 'Wajib', 'J002'),
('P033', 'Seni Budaya', 'Wajib', 'J002'),
('P034', 'Prakarya dan Kewirausahaan', 'Wajib', 'J002'),
('P035', 'Pendidikan Jasmani, Olah Raga & Kesehatan', 'Wajib', 'J002'),
('P036', 'Bahasa dan Sastra Daerah', 'Wajib', 'J002'),
('P037', 'Pengantar Ekonomi dan Bisnis', 'C1.  Dasar Bidang Keahlian', 'J002'),
('P038', 'Pengantar Administrasi Perkantoran', 'C1. Dasar Bidang Keahlian', 'J002'),
('P039', 'Pengantar Akuntansi', 'Wajib', 'J002'),
('P040', 'Teknologi Informasi /Otomatisasi Perkantoran', 'C2.  Dasar Program Keahlian', 'J002'),
('P041', 'Korespondensi', 'C1. Dasar Bidang Keahlian', 'J002'),
('P042', 'Kearsipan', 'C1. Dasar Bidang Keahlian', 'J002'),
('P043', 'Simulasi Digital', 'C2.  Dasar Program Keahlian', 'J002'),
('P044', 'Adminisrasi Kepegawaian', 'C3.  Paket Keahlian', 'J002'),
('P045', 'Administrasi Keuangan', 'C3.  Paket Keahlian', 'J002'),
('P046', 'Administrasi sarana dan prasarana', 'C3.  Paket Keahlian', 'J002'),
('P047', 'Administrasi Humas dan keprotokolan', 'C3.  Paket Keahlian', 'J002'),
('P048', 'Etika Komunikasi Bahasa Indonesia', 'C3.  Paket Keahlian', 'J002'),
('P049', 'Etika Komunikasi Bahas Inggris', 'C3.  Paket Keahlian', 'J002'),
('P050', 'Praktik Komputer ', 'C3.  Paket Keahlian', 'J002'),
('P051', 'Bahasa Jepang', 'D.  Muatan Lokal', 'J002'),
('P052', 'PLH', 'D.  Muatan Lokal', 'J002'),
('P053', 'BP/BK', 'D.  Muatan Lokal', 'J002'),
('P054', 'Pendidikan Agama dan Budi Pekerti', 'Wajib', 'J003'),
('P055', 'Pendidikan Pancasila dan Kewarganegaraan', 'Wajib', 'J003'),
('P056', 'Bahasa Indonesia', 'Wajib', 'J003'),
('P057', 'Matematika', 'Wajib', 'J003'),
('P058', 'Sejarah Indonesia', 'Wajib', 'J003'),
('P059', 'Bahasa Inggris', 'Wajib', 'J003'),
('P060', 'Seni Budaya', 'Wajib', 'J003'),
('P061', 'Prakarya dan Kewirausahaan', 'Wajib', 'J003'),
('P062', 'Pendidikan Jasmani, Olah Raga & Kesehatan', 'Wajib', 'J003'),
('P063', 'Bahasa dan Sastra Daerah', 'Wajib', 'J003'),
('P064', 'Pengantar Ekonomi dan Bisnis', 'Dasar Bidang Keahlian', 'J003'),
('P065', 'Pengantar Akuntansi', 'Dasar Bidang Keahlian', 'J003'),
('P066', 'Pengantar Administrasi Perkantoran', 'Dasar Bidang Keahlian', 'J003'),
('P067', 'Analisa dan Riset Pasar', 'Dasar Program Keahlian', 'J003'),
('P068', 'Perencanaan Pemasaran', 'Dasar Program Keahlian', 'J003'),
('P069', 'Pengelolaan Usaha Pemasaran', 'Dasar Program Keahlian', 'J003'),
('P070', 'Strategi Pemasaran', 'Dasar Program Keahlian', 'J003'),
('P071', 'Pemasaran On Line', 'Dasar Program Keahlian', 'J003'),
('P072', 'Simulasi Digital', 'Dasar Program Keahlian', 'J003'),
('P073', 'Prinsip prinsip ritel', 'Paket Keahlian', 'J003'),
('P074', 'Pengetahuan Barang', 'Paket Keahlian', 'J003'),
('P075', 'Penataan Barang dagangan', 'Paket Keahlian', 'J003'),
('P076', 'Kominkasi Bisnis', 'Paket Keahlian', 'J003'),
('P077', 'Administrasi barang', 'Paket Keahlian', 'J003'),
('P078', 'Administrasi Transaksi', 'Paket Keahlian', 'J003'),
('P079', 'Pelayanan Penjualan', 'Paket Keahlian', 'J003'),
('P080', 'Praktik Komputer ', 'Paket Keahlian', 'J003'),
('P081', 'Bahasa Jepang', 'Muatan Lokal', 'J003'),
('P082', 'PLH', 'Muatan Lokal', 'J003'),
('P083', 'BP/BK', 'Muatan Lokal', 'J003');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE IF NOT EXISTS `pembayaran` (
  `no_pembayaran` char(10) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `periode_awal` char(7) NOT NULL,
  `periode_akhir` char(7) NOT NULL,
  `kode_siswa` char(5) NOT NULL,
  `bayar_spp` int(12) NOT NULL,
  `bayar_dsp` int(12) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kode_user` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`no_pembayaran`, `tgl_pembayaran`, `periode_awal`, `periode_akhir`, `kode_siswa`, `bayar_spp`, `bayar_dsp`, `keterangan`, `kode_user`) VALUES
('SPP0000001', '2017-09-02', '09/2017', '10/2017', 'S0028', 540000, 400000, 'pembayaran 2 bulan', 'U001'),
('SPP0000002', '2017-09-02', '09/2017', '09/2017', 'S0071', 280000, 200000, 'Pembayaran 1 bulan', 'U001'),
('SPP0000003', '2017-09-02', '11/2017', '12/2017', 'S0028', 540000, 400000, 'pembayaran 2 bulan', 'U001'),
('SPP0000004', '2017-09-02', '09/2017', '11/2017', 'S0038', 810000, 600000, 'pembayaran 3 bulan', 'U001'),
('SPP0000005', '2017-09-02', '09/2017', '10/2017', 'S0029', 540000, 400000, 'pembayaran 2 bulan', 'U001');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_dks`
--

CREATE TABLE IF NOT EXISTS `pembayaran_dks` (
  `no_bayar_dks` char(7) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `kode_siswa` char(5) NOT NULL,
  `periode_ke` int(1) NOT NULL,
  `bayar_dks` int(12) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kode_user` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran_dks`
--

INSERT INTO `pembayaran_dks` (`no_bayar_dks`, `tgl_bayar`, `kode_siswa`, `periode_ke`, `bayar_dks`, `keterangan`, `kode_user`) VALUES
('DKS0001', '2017-10-06', 'S0001', 1, 5600000, 'Lunas', 'U003'),
('DKS0002', '2017-10-06', 'S0002', 1, 5800000, 'Lunas', 'U003'),
('DKS0003', '2017-10-08', 'S0003', 1, 5800000, 'Lunas', 'U003'),
('DKS0004', '2017-10-08', 'S0004', 1, 5600000, 'Lunas', 'U003'),
('DKS0005', '2017-10-10', 'S0005', 1, 5600000, 'Lunas', 'U003'),
('DKS0006', '2017-10-13', 'S0006', 1, 5600000, 'Lunas', 'U003'),
('DKS0007', '2017-10-14', 'S0007', 1, 5600000, 'Lunas', 'U003'),
('DKS0008', '2017-10-16', 'S0008', 1, 5600000, 'Lunas', 'U003'),
('DKS0009', '2017-11-05', 'S0009', 1, 5600000, 'Lunas', 'U003'),
('DKS0010', '2017-11-12', 'S0010', 1, 5800000, 'Lunas', 'U003'),
('DKS0011', '2018-01-16', 'S0007', 2, 5600000, 'Lunas', 'U003');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE IF NOT EXISTS `siswa` (
  `kode_siswa` char(5) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `agama` varchar(20) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `th_angkatan` varchar(9) NOT NULL,
  `kode_jurusan` char(4) NOT NULL,
  `kode_biaya` char(5) NOT NULL,
  `status` enum('Aktif','Lulus','Keluar') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`kode_siswa`, `nis`, `nama_siswa`, `kelamin`, `agama`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telepon`, `foto`, `th_angkatan`, `kode_jurusan`, `kode_biaya`, `status`) VALUES
('S0001', '130001', 'Indah Indriyanna', 'Perempuan', 'Islam', 'Way Jepara', '1982-10-25', 'Jl. Suhada, Way Jepara, Lampung Timur', '081911112345', '', '2018', 'J001', 'BS001', 'Aktif'),
('S0002', '130002', 'Septi Suhesti', 'Perempuan', 'Islam', 'Labuhan Ratu Satu', '1989-09-12', 'Jl. Syuhada, Labuhan Ratu Satu, Way Jepara', '085629002922', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0003', '130003', 'Bunafit Nugroho', 'Laki-laki', 'Islam', 'Labuhan Ratu Satu', '1982-09-14', 'Jl. Suhada, Way Jepara, Lampung Timur', '081325165478', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0004', '130004', 'Ummu Anitya Ningrum', 'Perempuan', 'Islam', 'Lampung Timur', '1998-12-22', 'Jl. Lebak Rejo No 115 Way Jepara', '081325123564', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0005', '130005', 'Rahmat Bayu Setiawan', 'Laki-laki', 'Islam', 'Lampung Timur', '1997-10-22', 'Jl . Jojoran 3a blok 1  11 Way Jepara', '081923876545', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0006', '130006', 'Fikri Ismail Abdullah', 'Laki-laki', 'Islam', 'Jakarta', '1996-09-13', 'Jl . Nagabanda 4 A/103 Way Jepara, Lampung Timur', '081325999878', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0007', '130007', 'Arif Wahyu Raharjo ', 'Laki-laki', 'Islam', 'Palembang', '1996-01-19', 'Jl. Babatan No 4 Way Jepara, Lampung Timur', '082311593454', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0008', '130008', 'Arista Oktaviani ', 'Perempuan', 'Kristen', 'Bandar Lampung', '1996-10-27', 'Jl. Babatan No 125 Way Jepara, Lampung Timur', '082315559789', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0009', '130009', 'Charenina Palupi', 'Perempuan', 'Kristen', 'Bandar Lampung', '1996-06-17', 'Jl. Babatan No 15 Way Jepara, Lampung Timur', '082175268855', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0010', '130010', 'Dita Halima Aprilia', 'Perempuan', 'Islam', 'Bandar Lampung', '1996-04-15', 'Jl. Bendul Merisi Gg Besar Selatan No. 38E', '082377757707', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0011', '130011', 'Ferthi Uspita Caturina', 'Perempuan', 'Katolik', 'Way Urang', '1996-09-15', 'Jl. Kedung Pengkol Gg 1 Seno No 78B Sukadana, Lampung Timur', '082175786545', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0012', '130012', 'Ikhlas Rafsanjani', 'Laki-laki', 'Islam', 'Bandar Lampung', '1996-08-26', 'Jl. Kedung Pengkol Gg 2 Seno No 56A Sukadana, Lampung Timur', '085729002965', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0013', '130013', 'Ahmad Azzam Al Asyraf ', 'Laki-laki', 'Islam', 'Bandar Lampung', '1996-08-02', 'Jl. Bogen II/19A Way Jepara, Lampung Timur', '085643660660', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0014', '130014', 'Bagus Robbiyanto', 'Laki-laki', 'Islam', 'Bandar Lampung', '1996-03-06', 'Jl. Bulak Rukem Timur IIab/8 Plangkawati, Way Jepara', '085729876767', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0015', '130015', 'Mira Ismayanti ', 'Perempuan', 'Islam', 'Bandar Lampung', '1996-05-26', 'Jl. Driyorejo Blok Intan 212 Braja Asri, Way Jepara', '085643555666', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0016', '130016', 'Muhammad Aprianto ', 'Laki-laki', 'Islam', 'Bandar Lampung', '1995-04-05', 'Jl. Dukuh Kupang Gg Lebar No 39C Simpang Sribawono', '085729002922', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0017', '130017', 'Nadya Pratiwi', 'Perempuan', 'Islam', 'Bandar Lampung', '1996-09-19', 'Jl. Dukuh Kupang Timur 19/60 Simpang Sribawono', '081541373489', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0018', '130018', 'Novia Sari Suwito Putri', 'Perempuan', 'Islam', 'Bandar Lampung', '1995-11-05', 'Jl. Gubeng Jaya II / 24 Braja Sakti, Way Jepara', '081541888789', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0019', '130019', 'Novita Dwi Lestari ', 'Perempuan', 'Kristen', 'Bandar Lampung', '1996-11-17', 'Jl. Jojoran 1 No 65G Way Jepara, Lampung Timur', '085357110575', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0020', '130020', 'Pipit Apriyanah', 'Perempuan', 'Islam', 'Bandar Lampung', '1996-04-11', 'Jl. Jojoran 1 No 86G Way Jepara, Lampung Timur', '085357667899', '', '2017', 'J001', 'BS001', 'Aktif'),
('S0021', '130021', 'Rizki Nurahman ', 'Laki-laki', 'Islam', 'Kotabumi', '1996-10-21', 'Jl. Jojoran 1 No 97G Way Jepara, Lampung Timur', '081272284905', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0022', '130022', 'Satrio Bayu Saputra', 'Laki-laki', 'Islam', 'Bandar Lampung', '1996-02-11', 'Jl. Jojoran I Blok AC No 20 Way Jepara, Lampung Timur', '085357402929', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0023', '130023', 'Selvi Herdiani ', 'Perempuan', 'Islam', 'Jakarta', '1996-09-05', 'Jl. Jojoran I Blok AC No 598 Way Jepara, Lampung Timur', '085727998979', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0024', '130024', 'Shahelia Hakim ', 'Perempuan', 'Islam', 'Pekanbaru', '1997-02-02', 'Jl. Jojoran I Blok AC No 56 Way Jepara, Lampung Timur', '081278929096', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0025', '130025', 'Sintia Ultari Agripinna Putri ', 'Perempuan', 'Islam', 'Kalianda', '1996-08-17', 'Jl. Jojoran I Blok AC No 120 Way Jepara, Lampung Timur', '081278879999', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0026', '130026', 'Vania Liandra Utami ', 'Perempuan', 'Islam', 'Tanjung Karang', '1996-04-29', 'Jl. Kalilom Lor Indah Melati No 42 Sukada, Lampung Timur', '081325987808', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0027', '130027', 'Wika Oktavia Mawarni', 'Perempuan', 'Islam', 'Bandar Lampung', '1996-10-03', 'Jl. Kalilom Lor Indah Melati No 85 Sukada, Lampung Timur', '085727889969', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0028', '130028', 'A. Yapri Indrawan', 'Laki-laki', 'Islam', 'Bandar Lampung', '1996-10-09', 'Jl. Kalilom Lor Indah Melati No 96 Sukada, Lampung Timur', '085729555666', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0029', '130029', 'Agra Nugraha Eka Putra', 'Laki-laki', 'Islam', 'Pringsewu', '1996-01-15', 'Jl. Kalilom Lor Indah Melati No 05 Sukada, Lampung Timur', '085643998789', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0030', '130030', 'Ahmad Ichsan ', 'Laki-laki', 'Islam', 'Bandar Lampung', '1996-03-17', 'Jl. Kampung Malang Utara 7/2A Metro', '082379193085', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0031', '130031', 'Akbar Ramadha', 'Laki-laki', 'Islam', 'Tanjung Karang', '1996-02-04', 'Jl. Kapasan Kidul 5 No. 08 Sukadana, Lampung Timur', '085840863724', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0032', '130032', 'Mas Achmad Hadiansyah', 'Laki-laki', 'Islam', 'Bandar Lampung', '1996-09-29', 'Jl. Kapasan Kidul 5 No. 56 Sukadana, Lampung Timur', '085383523808', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0033', '130033', 'Deni Pranata Wiguna ', 'Laki-laki', 'Islam', 'Bandar Lampung', '1996-03-04', 'Jl. Kapasan Kidul 5 No. 69 Sukadana, Lampung Timur', '081279151506', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0034', '130034', 'Yudi Purwanto', 'Laki-laki', 'Kristen', 'Bandar Lampung', '1996-08-06', 'Jl. Kedinding Lo Kemuning Gg II/64 Way Jepara, Lampung Timur', '082371752228', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0035', '130035', 'Ria Andriana', 'Perempuan', 'Islam', 'Bandar Lampung', '1996-09-08', 'Jl. Kedung Pengkol Gg 1 Seno No 53B Sukadana, Lampung Timur', '082226569326', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0036', '130036', 'Azizah Huwaida', 'Perempuan', 'Islam', 'Bandar Lampung', '1996-09-09', 'Jl. Kedung Pengkol Gg 1 Seno No 87C Sukadana, Lampung Timur', '083863524605', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0037', '130037', 'Siti Rahmani', 'Perempuan', 'Islam', 'Bandar Lampung', '1996-11-16', 'Jl. Lasem No 50A Braja Indah, Way Jepara', '081379466004', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0038', '130038', 'Aggy Rachman Putra', 'Laki-laki', 'Islam', 'Bandar Lampung', '1996-10-31', 'Jl. Komp Sidotopo Dipo 2 No 8 Braja Asri, Way Jepara', '081272754949', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0039', '130039', 'Nurul Aini Hilman', 'Perempuan', 'Islam', 'Lampung Timur', '1998-05-13', 'Jl. Oro-Oro 1 26 D Braja Indah, Way Jepara', '08127976954', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0040', '130040', 'Zahra Catrinnada Corie', 'Perempuan', 'Kristen', 'Lampung Timur', '1998-08-14', 'Jl. Pacarkembang 3 No 22D Sumberjo, Way Jepara', '081379827243', '', '2017', 'J002', 'BS002', 'Aktif'),
('S0041', '130041', 'Azahra Safira Adawiyah ', 'Perempuan', 'Islam', 'Lampung Timur', '1998-06-16', 'Jl. Pakel V/57 A Way Jepara, Lampung Timur', '085383009501', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0042', '130042', 'Gilang Nata Jaya', 'Laki-laki', 'Islam', 'Lampung Timur', '1997-12-25', 'Jl. Rangkah 3/ 20A Braja Sakti, Way Jepara', '082374720305', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0043', '130043', 'Hafif Restu Kurniadi', 'Laki-laki', 'Islam', 'Lampung Timur', '1997-12-31', ' Jl. Tambak Asri No 16 Simpang Sribawono, Lampung Timur', '082332098000', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0044', '130044', 'Ria Astuty ', 'Perempuan', 'Islam', 'Lampung Timur', '1996-01-01', 'Jl. Tapak Siring No. 32 Plangkawati, Way Jepara', '082180014849', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0045', '130045', 'Bella Apriliana ', 'Perempuan', 'Islam', 'Lampung Timur', '1998-04-12', 'Jl. Babatan Gg. Masjid No. 23 Sukadana, Lampung Timur', '081287058738', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0046', '130046', 'Gilang Ramadhan Andre Wardana', 'Laki-laki', 'Islam', 'Lampung Timur', '1998-01-22', ' Jl. Bagongginayan 5 No 16A Metro', '085269043060', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0047', '130047', 'Sulung Adi Indra Gusnawan', 'Laki-laki', 'Islam', 'Lampung Timur', '1998-08-02', 'Jl. Lasem No 23A Braja Indah, Way Jepara', '081369278263', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0048', '130048', 'Wahyu Nur Haliza ', 'Perempuan', 'Islam', 'Lampung Timur', '1999-03-06', ' Jl. Bhaskara 3/21 Way Jepara, Lampung Timur', '081369175560', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0049', '130049', 'Melisa Saras Wati', 'Perempuan', 'Islam', 'Lampung Timur', '1998-05-02', 'Jl. Bhaskara 4 / 23 Way Jepara, Lampung Timur', '085328678933', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0050', '130050', 'Bima Bayu Kusuma ', 'Laki-laki', 'Islam', 'Lampung Timur', '1998-03-28', ' Jl. Bogorami Makam No 01 Metro', '081369984505', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0051', '140051', 'Anantyo Ardi Tetuko', 'Laki-laki', 'Islam', 'Lampung Timur', '1998-02-27', 'Jl. Komp Sidotopo Dipo 2 No 25 Braja Asri, Way Jepara', '085384323343', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0052', '140052', 'Kiky Maykasari', 'Perempuan', 'Islam', 'Lampung Timur', '1998-05-26', 'Jl. Bronggalan Sawah 4i/78 Way Jepara, Lampung Timur', '085742423332', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0053', '140053', 'Didik Triyatmanto', 'Laki-laki', 'Islam', 'Lampung Timur', '1998-09-03', 'Jl. Bulak Banteng Baru Gg Teratai 40 Sukadana', '081906137867', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0054', '140054', 'Savira Pratiwi', 'Perempuan', 'Islam', 'Lampung Timur', '1998-07-17', 'Jl. Oro-Oro 1 65 D Braja Indah, Way Jepara', '085269875456', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0055', '140055', 'Zakton Indrawan', 'Laki-laki', 'Islam', 'Lampung Timur', '1998-06-10', ' Jl. Lebak Arum Gg1 No. 28 Way Areng', '085269547886', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0056', '140056', 'Ari Damayanti', 'Perempuan', 'Islam', 'Lampung ', '1999-01-09', 'Jl. Tapak Siring No. 52 Plangkawati, Way Jepara', '081802612178', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0057', '140057', 'Yolanda Eka Putri ', 'Perempuan', 'Islam', 'Jambi', '1998-07-29', 'Jl. Bulak Rukem Timur 1/97c Braja Selebah', '081377719178', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0058', '140058', 'Risky Bustami', 'Perempuan', 'Islam', 'Metro', '1998-10-14', 'Jl. Dukuh Bulak Banteng No 02 Way Jepara, Lampung Timur', '081541674657', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0059', '140059', 'Ayu Iteng Purnamasari', 'Perempuan', 'Islam', 'Tengerang', '1997-12-10', 'Jl. Dukuh Setro 2a/14 Sumber sari, Way Jepara', '081542258599', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0060', '140060', 'Nurul Hidayati', 'Perempuan', 'Islam', 'Lampung Tengah', '1998-06-04', 'Jl. Lasem No 97A Braja Indah, Way Jepara', '082175270389', '', '2017', 'J003', 'BS003', 'Aktif'),
('S0061', '140061', 'Anderson Dwi Wahono', 'Laki-laki', 'Islam', 'Metro', '1997-12-02', 'Jl. Dupak Rukun 6/9 Labuhan Ratu Dua, Way Jepara', '089671902009', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0062', '140062', 'Putri Apriliya Novitasari', 'Perempuan', 'Islam', 'Gunung Batin', '1997-04-08', 'Jl. Gadukan Utara 1C/4 Labuhan Ratu Dua, Way Jepara', '082327270244', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0063', '140063', 'Citra Dian Ratna', 'Perempuan', 'Islam', 'Bandar Lampung', '1998-01-05', 'Jl. Gubeng Kertajaya 2 No. 46 Labuhan Ratu Baru, Way Jepara', '085210821032', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0064', '140064', 'Andi Agit Setiawan ', 'Laki-laki', 'Islam', 'Indramayu', '1997-11-04', 'Jl. Gubeng Klingsingan 4/22 Labuhan Ratu Satu, Way Jepara', '081519840209', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0065', '140065', 'Ni Wayan Lasmi Kumara Tungga', 'Perempuan', 'Hindu', 'Yukum Jaya', '1997-02-06', 'Jl. Pacarkembang 3 No 65D Sumberjo, Way Jepara', '085669381766', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0066', '140066', 'Nur Ismawati ', 'Perempuan', 'Islam', 'Bekasi', '1998-06-16', 'Jl. Babatan Gg. Masjid No. 69 Sukadana, Lampung Timur', '085319246253', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0067', '140067', 'Rosa Alfia', 'Perempuan', 'Islam', 'Bandar Lampung', '1997-07-28', 'Jl. Gading Gg 2 No. 15 Sinar Banten, Way Jepara', '082374891545', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0068', '140068', 'Ilfi Intan Sari', 'Perempuan', 'Islam', 'Lampung', '1999-03-09', 'Jl. Memet Sastrawirja No. 44 Simpang Sribawono', '085208352090', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0069', '140069', 'Asop Zaenal Hayati ', 'Laki-laki', 'Islam', 'Tasik Malaya', '1997-09-13', 'Jl. Kalibutuh Barat 4/81 Mataram Baru, Simpang Sribawono', '081325168002', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0070', '140070', 'Ika Nur Chasanah', 'Perempuan', 'Islam', 'Lampung Timur', '1998-11-18', 'Jl. Mulyorejo Pertanian No. 2B Way Jepara', '081379473552', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0071', '140071', 'Adelia Pingky Dwi N', 'Perempuan', 'Islam', 'Majalengka', '1998-08-30', ' Jl. Bagongginayan 3 No 13C Metro', '082379197867', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0072', '140072', 'Eko Saputra', 'Laki-laki', 'Islam', 'Bandar Lampung', '1997-06-24', 'Jl. Kalijudan Barat 1a/12 Way Jepara, Lampung Timur', '081328012012', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0073', '140073', 'Virnada Agnuriska', 'Perempuan', 'Islam', 'Lampung Timur', '1998-08-25', 'Jl. Komp Sidotopo Dipo 2 No 35 Braja Asri, Way Jepara', '081325167995', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0074', '140074', 'Nyoman Asteyase', 'Laki-laki', 'Hindu', 'Lampung', '1997-11-13', 'Jl. Kalilom Lor Indah Gg Delima No 13 Plangkawati, Way Jepara', '085377401188', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0075', '140075', 'Febrian Farizky ', 'Laki-laki', 'Islam', 'Lampung Timur', '1998-02-28', 'Jl. Babatan Gg. Masjid No. 42 Sukadana, Lampung Timur', '085267886505', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0076', '140076', 'Bella Dwi Putri ', 'Perempuan', 'Islam', 'Lampung Timur', '1998-04-15', 'Jl. Kapasari Pedukuhan Gang Buntu C/31A Braja Sakti, Way Jepara', '085269077891', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0077', '140077', 'Yogi Etsun Pranata ', 'Laki-laki', 'Islam', 'Lampung Timur', '1998-05-07', ' Jl. Tambak Asri No 12 Simpang Sribawono, Lampung Timur', '081369723691', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0078', '140078', 'Vitha Cyntya Aderia', 'Perempuan', 'Islam', 'Lampung Tengah', '1998-04-14', 'Jl. Kedeung Anyar V Tengah No 01 Sri Wangi, Way Areng', '081272888122', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0079', '140079', 'Dimas Galang Febriawan', 'Laki-laki', 'Islam', 'Lampung Timur', '0998-02-13', ' Jl. Bagongginayan 5 No 65A Metro', '082185028262', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0080', '140080', 'Mutiara Cahya Mala Wangi', 'Perempuan', 'Islam', 'Lampung Timur', '1998-07-08', ' Jl. Kedung Anyar Kuburan No 07 Tridatu', '081273397328', '', '2017', 'J004', 'BS004', 'Aktif'),
('S0081', '140081', 'Aminova Dian Hariani', 'Perempuan', 'Islam', 'Wonigiri', '1998-11-12', 'Jl. Pacar Kembang V Baru No. 22 Sinar Banten, Way Jepara', '081280467055', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0082', '140082', 'Puput Arnianto ', 'Perempuan', 'Islam', 'Wonigiri', '1998-05-06', 'Jl. Kedung Mangu Timur 4/10 Tridatu, Lampung Timur', '081369770172', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0083', '140083', 'Nursafitri', 'Perempuan', 'Islam', 'Tanjung Harapan', '1998-03-03', ' Jl. Bogorami Makam No 35 Metro', '08158070857', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0084', '140084', 'Nopvia Margaretha', 'Perempuan', 'Islam', 'Lampung Timur', '1997-11-27', 'Jl. Kedung Pengkol 3 No.16B Way Jepara', '085228075194', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0085', '140085', 'Sri Ahdiyani ', 'Perempuan', 'Islam', 'Karawang', '1997-01-11', 'Jl. Kejawan Putih Tambak Gg. Hidrodinamika No. 04 Way Areng', '082185077763', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0086', '140086', 'Heriyanto ', 'Laki-laki', 'Islam', 'Bekasi', '1998-05-04', 'Jl. Kalilom Lor Indah Gg Salak No 04 Plangkawati, Way Jepara', '081311289446', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0087', '140087', 'Dwi Agung Sigit Handika', 'Laki-laki', 'Islam', 'Lampung Timur', '1996-10-08', 'Jl. Gading Gg 2 No. 46 Sinar Banten, Way Jepara', '085601537219', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0088', '140088', 'Agung Pandu Harto ', 'Laki-laki', 'Islam', 'Lampung Timur', '1998-03-28', 'Jl. Lasem No 47A Braja Indah, Way Jepara', '082177160272', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0089', '140089', 'Wayan Wirtha Dharma', 'Laki-laki', 'Hindu', 'Lampung Timur', '1998-07-17', 'Jl. Tapak Siring No. 02 Plangkawati, Way Jepara', '081379949095', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0090', '140090', 'Eza Dhea Zahara', 'Perempuan', 'Islam', 'Lampung Timur', '1998-12-20', 'Jl. Dukuh Bulak Banteng No 32 Way Jepara, Lampung Timur', '081272520288', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0091', '140091', 'Ni Made Laksmi Devi', 'Perempuan', 'Hindu', 'Seputih Mataram', '1998-03-28', ' Jl. Bogorami Makam No 22 Metro', '085366212891', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0092', '140092', 'Titania Candra Sainda ', 'Perempuan', 'Islam', 'Belintang', '1998-12-09', ' Jl. Bhaskara 7/9 Way Jepara, Lampung Timur', '085768679645', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0093', '140093', 'Dewa Ayu Kade Rai Shantika ', 'Perempuan', 'Hindu', 'Lampung Timur', '1998-11-26', 'Jl Pacarkembang 4 No 67A Sumberjo, Way Jepara', '085769943974', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0094', '140094', 'Dimas Pramesty Putra', 'Laki-laki', 'Islam', 'Lampung Timur', '0000-00-00', ' Jl. Tambak Asri No 89 Simpang Sribawono, Lampung Timur', '081928222948', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0095', '140095', 'Putu Andri Sania Devi ', 'Perempuan', 'Hindu', 'Lampung Tengah', '1998-06-30', ' Jl. Bagongginayan 3 No 23B Metro', '085279876154', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0096', '140096', 'Yuni Setia Ningrum', 'Perempuan', 'Islam', 'Metro', '1998-06-14', 'Jl. Babatan Gg. Masjid No. 35 Sukadana, Lampung Timur', '085658969293', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0097', '140097', 'Bima Cahya Ardika', 'Laki-laki', 'Islam', 'Lampung Timur', '1998-07-21', 'Jl. Komp Sidotopo Dipo 2 No 68 Braja Asri, Way Jepara', '082183387866', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0098', '140098', 'Kristian Prajna Kusuma Dharma ', 'Perempuan', 'Kristen', 'Kuala Tangkal', '1998-09-12', 'Jl. Tapak Siring No. 63 Plangkawati, Way Jepara', '085269919726', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0099', '140099', 'Amanda Dewi Rosita ', 'Perempuan', 'Islam', 'Bandar Lampung', '1997-05-17', ' Jl. Tambak Asri No 34 Simpang Sribawono, Lampung Timur', '085840968848', '', '2017', 'J005', 'BS005', 'Aktif'),
('S0100', '140100', 'Anggun Distiana Sani', 'Perempuan', 'Islam', 'Bandar Lampung', '1997-10-14', 'Jl Pacarkembang 4 No 12A Sumberjo, Way Jepara', '081901282144', '', '2017', 'J005', 'BS005', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `kode_user` char(4) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` enum('Admin','Pengajaran','Kasir') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`kode_user`, `nama_user`, `username`, `password`, `level`) VALUES
('U001', 'Bunafit Nugroho', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
('U002', 'Indah Indriyanna', 'indah', 'f3385c508ce54d577fd205a1b2ecdfb7', 'Pengajaran'),
('U003', 'Fitria Prasetiawati', 'fitria', 'ef208a5dfcfc3ea9941d7a6c43841784', 'Kasir'),
('U004', 'User Baru', 'userbaru', '81dc9bdb52d04dc20036dbd8313ed055', 'Kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `biaya_sekolah`
--
ALTER TABLE `biaya_sekolah`
 ADD PRIMARY KEY (`kode_biaya`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
 ADD PRIMARY KEY (`kode_guru`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
 ADD PRIMARY KEY (`kode_jabatan`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
 ADD PRIMARY KEY (`kode_jurusan`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
 ADD PRIMARY KEY (`kode_kelas`);

--
-- Indexes for table `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelajaran`
--
ALTER TABLE `pelajaran`
 ADD PRIMARY KEY (`kode_pelajaran`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
 ADD PRIMARY KEY (`no_pembayaran`);

--
-- Indexes for table `pembayaran_dks`
--
ALTER TABLE `pembayaran_dks`
 ADD PRIMARY KEY (`no_bayar_dks`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
 ADD PRIMARY KEY (`kode_siswa`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`kode_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
