-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 27, 2011 at 01:54 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pesawat`
--

-- --------------------------------------------------------

--
-- Table structure for table `tm_admin`
--

CREATE TABLE IF NOT EXISTS `tm_admin` (
  `admin_id` varchar(20) NOT NULL,
  `admin_nama` varchar(50) NOT NULL,
  `admin_password` varchar(50) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tm_admin`
--

INSERT INTO `tm_admin` (`admin_id`, `admin_nama`, `admin_password`) VALUES
('admin', 'Administrator', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `tm_kelas`
--

CREATE TABLE IF NOT EXISTS `tm_kelas` (
  `kelas_id` varchar(20) NOT NULL,
  `kelas_nama` varchar(50) NOT NULL,
  PRIMARY KEY (`kelas_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tm_kelas`
--

INSERT INTO `tm_kelas` (`kelas_id`, `kelas_nama`) VALUES
('promo', 'Promo'),
('ekonomi', 'Ekonomi'),
('eksekutif', 'Eksekutif'),
('premium', 'Premium');

-- --------------------------------------------------------

--
-- Table structure for table `tm_maskapai`
--

CREATE TABLE IF NOT EXISTS `tm_maskapai` (
  `maskapai_id` varchar(20) NOT NULL,
  `maskapai_nama` varchar(50) NOT NULL,
  `maskapai_telp` varchar(20) NOT NULL,
  `maskapai_alamat` text NOT NULL,
  PRIMARY KEY (`maskapai_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tm_maskapai`
--

INSERT INTO `tm_maskapai` (`maskapai_id`, `maskapai_nama`, `maskapai_telp`, `maskapai_alamat`) VALUES
('airasia', 'Air Asia', '099099', 'Surabaya'),
('lionair', 'Lion Air', '089089', 'Singapura'),
('garuda', 'Garuda Indonesia', '008880', 'Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `tm_pemesan`
--

CREATE TABLE IF NOT EXISTS `tm_pemesan` (
  `pemesan_id` int(11) NOT NULL AUTO_INCREMENT,
  `jadwal_id` int(11) NOT NULL,
  `kelas_id` varchar(20) NOT NULL,
  `pemesan_tanggal` datetime NOT NULL,
  `pemesan_nama` varchar(50) NOT NULL,
  `pemesan_telp` varchar(20) NOT NULL,
  `pemesan_email` varchar(50) NOT NULL,
  `pemesan_alamat` text NOT NULL,
  `pemesan_pengenal` varchar(20) NOT NULL,
  `pemesan_kode` varchar(32) NOT NULL,
  `pemesan_kode_transfer` varchar(50) NOT NULL,
  `pemesan_transfer_nilai` int(11) NOT NULL,
  `pemesan_aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `pemesan_disetujui` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`pemesan_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tm_pemesan`
--

INSERT INTO `tm_pemesan` (`pemesan_id`, `jadwal_id`, `kelas_id`, `pemesan_tanggal`, `pemesan_nama`, `pemesan_telp`, `pemesan_email`, `pemesan_alamat`, `pemesan_pengenal`, `pemesan_kode`, `pemesan_kode_transfer`, `pemesan_transfer_nilai`, `pemesan_aktif`, `pemesan_disetujui`) VALUES
(1, 1, 'promo', '2011-07-25 12:00:00', 'Mahendri Winata', '085721821555', 'mahen.0112@gmail.com', 'Banyuwangi', '30108485', '66529bd249ce1332050bfee645e2d7bd', '', 0, 'Y', 'N'),
(3, 1, 'promo', '2011-07-25 12:00:00', 'mahendra', '000087665', 'oke', 'bandung', '00012455', '34b98982c145662f6a95433ba7841782', '678ijuhgghjkkaghkjklajggffgtuy66898675655', 500000, 'Y', 'Y'),
(4, 1, 'promo', '2011-07-25 12:00:00', 'mahen', '56799', 'MAHEN', 'jhjhio', '657864907556', '9d4f23af7e5c1803d9f4970cba97d898', '', 0, 'Y', 'N'),
(5, 1, 'ekonomi', '2011-07-25 00:00:00', 'oki', '9876588', 'hhhg', 'jjbvgg', '6998654467899', 'e74ab87aeae53420cbfd99be2cf70cc4', '', 0, 'N', 'N'),
(6, 1, 'eksekutif', '2011-07-12 00:00:00', 'hhggg', '6878654', 'mhggg', 'jhgff', '6898ujhgui', '618ab2159eab821197631798856fa252', 'hh778998655', 500000, 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tm_pesawat`
--

CREATE TABLE IF NOT EXISTS `tm_pesawat` (
  `pesawat_id` varchar(20) NOT NULL,
  `pesawat_tipe` varchar(20) NOT NULL,
  `pesawat_keterangan` text NOT NULL,
  `maskapai_id` varchar(20) NOT NULL,
  PRIMARY KEY (`pesawat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tm_pesawat`
--

INSERT INTO `tm_pesawat` (`pesawat_id`, `pesawat_tipe`, `pesawat_keterangan`, `maskapai_id`) VALUES
('LA01', 'Cargo', '', 'lionair'),
('LA02', 'Cargo', '', 'lionair'),
('AA01', 'Cargo', '', 'airasia'),
('AA02', 'Cargo', 'New 2010', 'airasia');

-- --------------------------------------------------------

--
-- Table structure for table `tp_kota`
--

CREATE TABLE IF NOT EXISTS `tp_kota` (
  `kota_id` varchar(20) NOT NULL,
  `kota_nama` varchar(50) NOT NULL,
  PRIMARY KEY (`kota_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tp_kota`
--

INSERT INTO `tp_kota` (`kota_id`, `kota_nama`) VALUES
('BDG', 'Bandung'),
('JKT', 'Jakarta'),
('SBY', 'Surabaya'),
('DPR', 'Denpasar'),
('MND', 'Manado'),
('BPN', 'Balikpapan'),
('MDN', 'Medan'),
('PLG', 'Palembang'),
('SMR', 'Samarinda'),
('MRK', 'Merauke'),
('BWI', 'Banyuwangi'),
('PLU', 'Palu');

-- --------------------------------------------------------

--
-- Table structure for table `tt_jadwal`
--

CREATE TABLE IF NOT EXISTS `tt_jadwal` (
  `jadwal_id` int(11) NOT NULL AUTO_INCREMENT,
  `pesawat_kota_id` int(11) NOT NULL,
  `jadwal_berangkat` datetime NOT NULL,
  `jadwal_tiba` datetime NOT NULL,
  PRIMARY KEY (`jadwal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tt_jadwal`
--

INSERT INTO `tt_jadwal` (`jadwal_id`, `pesawat_kota_id`, `jadwal_berangkat`, `jadwal_tiba`) VALUES
(1, 1, '2011-07-26 10:10:00', '2011-07-26 12:10:00'),
(2, 6, '2011-07-26 10:10:00', '2011-07-26 12:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `tt_jadwal_kelas`
--

CREATE TABLE IF NOT EXISTS `tt_jadwal_kelas` (
  `jadwal_kelas_id` int(11) NOT NULL AUTO_INCREMENT,
  `jadwal_id` int(11) NOT NULL,
  `kelas_id` varchar(20) NOT NULL,
  `jadwal_kelas_max` int(11) NOT NULL,
  `jadwal_kelas_harga` int(11) NOT NULL,
  PRIMARY KEY (`jadwal_kelas_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tt_jadwal_kelas`
--

INSERT INTO `tt_jadwal_kelas` (`jadwal_kelas_id`, `jadwal_id`, `kelas_id`, `jadwal_kelas_max`, `jadwal_kelas_harga`) VALUES
(1, 1, 'promo', 30, 500000),
(2, 1, 'ekonomi', 45, 550000),
(3, 1, 'eksekutif', 20, 700000),
(4, 2, 'promo', 25, 60000),
(5, 2, 'ekonomi', 20, 700000),
(6, 2, 'premium', 20, 800000),
(7, 2, 'eksekutif', 30, 1000000);

-- --------------------------------------------------------

--
-- Table structure for table `tt_pesawat_kota`
--

CREATE TABLE IF NOT EXISTS `tt_pesawat_kota` (
  `pesawat_kota_id` int(11) NOT NULL AUTO_INCREMENT,
  `pesawat_id` varchar(20) NOT NULL,
  `pesawat_kota_asal` varchar(20) NOT NULL,
  `pesawat_kota_tujuan` varchar(20) NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  PRIMARY KEY (`pesawat_kota_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tt_pesawat_kota`
--

INSERT INTO `tt_pesawat_kota` (`pesawat_kota_id`, `pesawat_id`, `pesawat_kota_asal`, `pesawat_kota_tujuan`, `aktif`) VALUES
(1, 'LA02', 'JKT', 'SBY', 'Y'),
(2, 'LA01', 'BDG', 'SBY', 'Y'),
(3, 'LA01', 'PLG', 'JKT', 'Y'),
(4, 'LA01', 'SMR', 'MRK', 'Y'),
(6, 'LA01', 'BDG', 'BWI', 'Y');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
