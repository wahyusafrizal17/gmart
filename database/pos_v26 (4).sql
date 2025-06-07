-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26 Mei 2022 pada 01.19
-- Versi Server: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pos_v26`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_delete`
--

CREATE TABLE IF NOT EXISTS `activity_delete` (
`id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `oleh` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data untuk tabel `activity_delete`
--

INSERT INTO `activity_delete` (`id`, `url`, `oleh`, `datetime`) VALUES
(1, 'http://localhost/posv26/dashboard/welcome.php?page=delete/hapus&id_photo=7&img=261e955462fd66.jpeg', 2, '2022-01-27 03:38:42'),
(2, 'http://localhost/posv26/dashboard/welcome.php?page=delete/hapus&id_photo=8&img=261f213b397b7b.png', 2, '2022-01-27 03:38:46'),
(3, 'http://localhost/kasirfix/dashboard/welcome.php?page=barcode/delete&id_barcode=1', 1, '2022-05-21 14:29:06'),
(4, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=42', 2, '2022-05-21 15:11:55'),
(5, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=41', 2, '2022-05-21 15:16:03'),
(6, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=99', 2, '2022-05-21 15:16:21'),
(7, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=44', 2, '2022-05-21 15:19:50'),
(8, 'http://localhost/kasirfix/dashboard/welcome.php?page=delete/hapus&id_photo=5&img=26031b740bdbe9.jpg', 2, '2022-05-21 22:30:28'),
(9, 'http://localhost/kasirfix/dashboard/welcome.php?page=scan/delete&id=10', 2, '2022-05-22 09:51:35'),
(10, 'http://localhost/kasirfix/dashboard/welcome.php?page=scan/delete&id=11', 2, '2022-05-22 09:51:37'),
(11, 'http://localhost/kasirfix/dashboard/welcome.php?page=barcode/delete&id_barcode=2', 2, '2022-05-22 11:17:49'),
(12, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=50', 2, '2022-05-24 12:01:24'),
(13, 'http://localhost/kasirfix/dashboard/welcome.php?page=scan/delete&id=9', 2, '2022-05-25 08:08:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_update`
--

CREATE TABLE IF NOT EXISTS `activity_update` (
`id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `oleh` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data untuk tabel `activity_update`
--

INSERT INTO `activity_update` (`id`, `url`, `oleh`, `datetime`) VALUES
(1, 'http://localhost/posv26/dashboard/welcome.php?page=kategori/update&id_kategori=2', 2, '2022-01-27 03:42:23'),
(2, 'http://localhost/kasirfix/dashboard/welcome.php?page=kassa/update&id_kassa=12', 2, '2022-05-21 14:50:48'),
(3, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=99', 2, '2022-05-21 14:54:21'),
(4, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=99', 2, '2022-05-21 14:54:29'),
(5, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=4', 2, '2022-05-21 14:54:39'),
(6, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=42', 2, '2022-05-21 14:54:57'),
(7, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=4', 2, '2022-05-21 15:14:00'),
(8, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=5', 2, '2022-05-21 15:14:36'),
(9, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=2', 2, '2022-05-21 15:14:46'),
(10, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=3', 2, '2022-05-21 15:14:59'),
(11, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=43', 2, '2022-05-21 15:16:01'),
(12, 'http://localhost/kasirfix/dashboard/welcome.php?page=kassa/update&id_kassa=12', 2, '2022-05-25 10:03:59'),
(13, 'http://localhost/kasirfix/dashboard/welcome.php?page=kassa/update&id_kassa=12', 2, '2022-05-25 10:04:10'),
(14, 'http://localhost/kasirfix/dashboard/welcome.php?page=kassa/update&id_kassa=8', 2, '2022-05-25 10:07:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barcode`
--

CREATE TABLE IF NOT EXISTS `barcode` (
`id_barcode` int(11) NOT NULL,
  `barcode` varchar(15) NOT NULL,
  `qtybarcode` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `addby` int(11) NOT NULL,
  `tercatat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `faktur`
--

CREATE TABLE IF NOT EXISTS `faktur` (
`idfaktur` int(11) NOT NULL,
  `tglfaktur` date NOT NULL,
  `kodefaktur` varchar(11) NOT NULL,
  `jenisbayar` enum('CASH','TRANSFER','SHOPEEPAY','MERCHANT','LAINNYA') NOT NULL DEFAULT 'CASH',
  `addedfaktur` int(11) NOT NULL,
  `addbyfaktur` int(11) NOT NULL,
  `periode` varchar(5) NOT NULL,
  `datetimefaktur` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kembalian` double DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `totalbayar` double DEFAULT NULL,
  `namapelanggan` varchar(100) DEFAULT NULL COMMENT 'fitur 20 Januari dari topoci',
  `nohp` varchar(22) DEFAULT NULL,
  `statusfaktur` enum('Y','N') NOT NULL DEFAULT 'N',
  `qtyprint` int(11) NOT NULL,
  `printby` int(11) NOT NULL,
  `adminfaktur` varchar(30) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Trigger `faktur`
--
DELIMITER //
CREATE TRIGGER `hapus_detailfaktur` BEFORE DELETE ON `faktur`
 FOR EACH ROW BEGIN
	DELETE FROM transaksidetail
    WHERE transaksidetail.faktur = OLD.kodefaktur;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `harga`
--

CREATE TABLE IF NOT EXISTS `harga` (
`idharga` int(11) NOT NULL,
  `kodeproduk` varchar(15) NOT NULL,
  `hargajual` double NOT NULL,
  `hargabaru` double NOT NULL,
  `hargadasar` double NOT NULL,
  `namaprodukOld` varchar(100) NOT NULL,
  `namaprodukBaru` varchar(100) NOT NULL,
  `added` int(11) NOT NULL,
  `addby` int(11) NOT NULL,
  `tercatat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kassa`
--

CREATE TABLE IF NOT EXISTS `kassa` (
`id_kassa` int(11) NOT NULL,
  `user_kassa` varchar(10) NOT NULL,
  `pwd_kassa` varchar(50) NOT NULL,
  `nama_kassa` varchar(60) NOT NULL,
  `alamat_kassa` varchar(255) NOT NULL,
  `telp_kassa` varchar(25) NOT NULL,
  `level_kassa` int(11) NOT NULL DEFAULT '3',
  `status_kassa` enum('Y','N') NOT NULL DEFAULT 'Y',
  `added_kassa` int(11) NOT NULL,
  `updated_kassa` int(11) NOT NULL,
  `addby_kassa` int(11) NOT NULL,
  `key_kassa` varchar(20) NOT NULL DEFAULT 'viewpr4t4m4'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `kassa`
--

INSERT INTO `kassa` (`id_kassa`, `user_kassa`, `pwd_kassa`, `nama_kassa`, `alamat_kassa`, `telp_kassa`, `level_kassa`, `status_kassa`, `added_kassa`, `updated_kassa`, `addby_kassa`, `key_kassa`) VALUES
(8, 'kasir', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 'Kasir', 'Bolai Guguak', '082284980398', 3, 'Y', 1642681857, 1653473272, 2, 'viewpr4t4m4'),
(12, 'sudir', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'Sudir Kasir', 'Jl Karasak cupak\r\n', '082283751455', 3, 'Y', 1653142481, 1653473050, 1, 'viewpr4t4m4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
`idkategori` int(11) NOT NULL,
  `namakategori` varchar(30) NOT NULL,
  `ketkategori` varchar(100) DEFAULT NULL,
  `addedkategori` int(11) NOT NULL DEFAULT '123',
  `updatedkategori` int(11) NOT NULL,
  `addbykategori` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`, `ketkategori`, `addedkategori`, `updatedkategori`, `addbykategori`) VALUES
(2, 'alat mandi', NULL, 1642684250, 1653146086, 2),
(3, 'babyset', NULL, 1642684668, 1653146099, 2),
(4, 'AKSESORIS', NULL, 1642685201, 1653146040, 2),
(5, 'alat makan minum', NULL, 1642825009, 1653146076, 2),
(101, 'baju atasan', NULL, 1653146113, 0, 2),
(102, 'bantal', NULL, 1653146121, 0, 2),
(103, 'bedong', NULL, 1653146125, 0, 2),
(104, 'celana', NULL, 1653146128, 0, 2),
(105, 'dress', NULL, 1653146195, 0, 2),
(106, 'gamis', NULL, 1653146199, 0, 2),
(107, 'gendongan', NULL, 1653146202, 0, 2),
(108, 'gigitan', NULL, 1653146206, 0, 2),
(109, 'gurita', NULL, 1653146210, 0, 2),
(110, 'handuk', NULL, 1653146214, 0, 2),
(111, 'hijab', NULL, 1653146217, 0, 2),
(112, 'jacket', NULL, 1653146220, 0, 2),
(113, 'jumsuit', NULL, 1653146224, 0, 2),
(114, 'kain panjang', NULL, 1653146229, 0, 2),
(115, 'kasur', NULL, 1653146234, 0, 2),
(116, 'kaus kaki', NULL, 1653146238, 0, 2),
(117, 'kebutuhan ibu', NULL, 1653146242, 0, 2),
(118, 'koko', NULL, 1653146247, 0, 2),
(119, 'leging', NULL, 1653146251, 0, 2),
(120, 'mainan', NULL, 1653146254, 0, 2),
(121, 'perlak', NULL, 1653146257, 0, 2),
(122, 'popok', NULL, 1653146260, 0, 2),
(123, 'selimut', NULL, 1653146265, 0, 2),
(124, 'sepatu', NULL, 1653146269, 0, 2),
(125, 'sepeda', NULL, 1653146272, 0, 2),
(126, 'setelan baby', NULL, 1653146277, 0, 2),
(127, 'setelan balita', NULL, 1653146281, 0, 2),
(128, 'singlet', NULL, 1653146285, 0, 2),
(129, 'songkok', NULL, 1653146290, 0, 2),
(130, 'sugar baby', NULL, 1653146294, 0, 2),
(131, 'tas', NULL, 1653146298, 0, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode`
--

CREATE TABLE IF NOT EXISTS `periode` (
`idperiode` int(11) NOT NULL,
  `kodeperiode` varchar(5) NOT NULL,
  `ketperiode` varchar(30) NOT NULL,
  `sttperiode` enum('Y','N') NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `periode`
--

INSERT INTO `periode` (`idperiode`, `kodeperiode`, `ketperiode`, `sttperiode`) VALUES
(1, '2022', 'Periode 2022', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE IF NOT EXISTS `produk` (
`idproduk` int(11) NOT NULL,
  `namaproduk` varchar(100) NOT NULL,
  `kategori` int(11) NOT NULL,
  `deskproduk` varchar(200) DEFAULT NULL,
  `hargadasar` double NOT NULL,
  `hargajual` double NOT NULL,
  `kodeproduk` varchar(15) NOT NULL,
  `satuan` varchar(15) NOT NULL COMMENT 'di distinct',
  `stok` int(11) NOT NULL,
  `minProduk` int(11) DEFAULT NULL COMMENT 'Alert Minimal',
  `statusproduk` enum('Y','N') NOT NULL DEFAULT 'Y',
  `addedproduk` int(11) NOT NULL DEFAULT '123',
  `updatedproduk` int(11) NOT NULL,
  `addbyproduk` int(11) NOT NULL,
  `alertproduk` varchar(255) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`idproduk`, `namaproduk`, `kategori`, `deskproduk`, `hargadasar`, `hargajual`, `kodeproduk`, `satuan`, `stok`, `minProduk`, `statusproduk`, `addedproduk`, `updatedproduk`, `addbyproduk`, `alertproduk`) VALUES
(43, 'Empeng HUKI', 5, NULL, 15000, 25000, '8991003060219', 'pcs', 2, NULL, 'Y', 1653145144, 1653146161, 2, NULL),
(45, 'topi YKS', 4, NULL, 4000, 8000, '070102', 'PCS', 5, NULL, 'Y', 1653146367, 0, 2, NULL),
(46, 'gurita tempel yks', 4, NULL, 22500, 32000, '070101', 'PCS', 0, NULL, 'Y', 1653146412, 0, 2, NULL),
(47, 'topi Nia ', 4, NULL, 7000, 12000, '010405', 'PCS', 32, NULL, 'Y', 1653172487, 0, 2, NULL),
(48, 'turban vinata ', 4, NULL, 7500, 12000, '011504', 'PCS', 20, NULL, 'Y', 1653172518, 0, 2, NULL),
(49, 'empeng lily', 5, NULL, 25000, 35000, '2391852988492', 'PCS', 5, NULL, 'Y', 1653172559, 0, 2, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `returnproduk`
--

CREATE TABLE IF NOT EXISTS `returnproduk` (
`id_return` int(11) NOT NULL,
  `asalfaktur` varchar(11) NOT NULL,
  `produkreturn` varchar(15) NOT NULL,
  `qtyreturn` int(11) NOT NULL,
  `ketreturn` varchar(255) NOT NULL,
  `addedreturn` int(11) NOT NULL,
  `addbyreturn` int(11) NOT NULL,
  `tercatatreturn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `namareturn` varchar(50) DEFAULT NULL,
  `hargadasar` double DEFAULT NULL,
  `hargajual` double DEFAULT NULL,
  `periode` varchar(5) NOT NULL,
  `tglreturn` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE IF NOT EXISTS `stok` (
`id_stok` int(11) NOT NULL,
  `status` enum('T','K') NOT NULL,
  `qty` int(11) NOT NULL,
  `produkID` int(11) NOT NULL,
  `oldStok` int(11) NOT NULL,
  `barcode` varchar(15) NOT NULL,
  `namaproduk` varchar(100) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `tastok` varchar(5) NOT NULL DEFAULT '2021',
  `added` int(11) NOT NULL,
  `addby` int(11) NOT NULL,
  `tercatat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Mencatat Perubahan Stok Barang' AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `stok`
--

INSERT INTO `stok` (`id_stok`, `status`, `qty`, `produkID`, `oldStok`, `barcode`, `namaproduk`, `ket`, `tastok`, `added`, `addby`, `tercatat`) VALUES
(1, 'T', 10, 43, -7, '8991003060219', 'Empeng HUKI', NULL, '2022', 1653217960, 2, '2022-05-22 11:12:40'),
(2, 'T', 10, 49, -5, '2391852988492', 'empeng lily', NULL, '2022', 1653217999, 2, '2022-05-22 11:13:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE IF NOT EXISTS `tb_admin` (
`id_admin` int(11) NOT NULL,
  `Login` varchar(10) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `gender_admin` enum('L','P') NOT NULL,
  `address_admin` varchar(255) DEFAULT NULL,
  `email_admin` varchar(100) NOT NULL,
  `hp_admin` varchar(12) NOT NULL,
  `photo_admin` varchar(100) DEFAULT NULL,
  `Level` int(11) NOT NULL,
  `active_admin` enum('Y','N') NOT NULL,
  `waktuawal_admin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `key_admin` varchar(50) DEFAULT NULL,
  `cabang_id` int(11) NOT NULL COMMENT 'Agar mudah proses perubahan daripada Kode'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `Login`, `Password`, `nama_admin`, `gender_admin`, `address_admin`, `email_admin`, `hp_admin`, `photo_admin`, `Level`, `active_admin`, `waktuawal_admin`, `key_admin`, `cabang_id`) VALUES
(2, 'admin', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'GNSTORE', 'P', 'JL.BOLAI GUGUAK', 'ghalihmandaveqia24@gmail.com', '082284980398', '2628967fb70d3e.png', 2, 'Y', '2021-02-17 08:19:10', 'admin123', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_config`
--

CREATE TABLE IF NOT EXISTS `tb_config` (
`id_config` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `header` varchar(50) DEFAULT NULL,
  `footer` varchar(100) DEFAULT NULL,
  `text1` varchar(255) DEFAULT NULL,
  `text2` text,
  `text3` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tb_config`
--

INSERT INTO `tb_config` (`id_config`, `title`, `deskripsi`, `header`, `footer`, `text1`, `text2`, `text3`) VALUES
(1, 'GNSTORE', 'www.instagram.com/ghalihmahdaveqia/', 'KASIR', 'GNSTORE', 'Jl. Bolai Guguak - Sumatera Barat<br>No. HP: 082284980398', '- Terima Kasih telah belanja di GNSTORE -', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_master`
--

CREATE TABLE IF NOT EXISTS `tb_master` (
`id_master` int(11) NOT NULL,
  `Login` varchar(10) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `nama_master` varchar(50) NOT NULL,
  `photo_master` varchar(100) DEFAULT NULL,
  `key_master` varchar(25) NOT NULL,
  `Level` int(11) NOT NULL,
  `active_master` enum('Y','N') NOT NULL,
  `cabang_id` int(11) NOT NULL COMMENT '26 Desember'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tb_master`
--

INSERT INTO `tb_master` (`id_master`, `Login`, `Password`, `nama_master`, `photo_master`, `key_master`, `Level`, `active_master`, `cabang_id`) VALUES
(1, 'ghalihinz', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 'GHALIH MASTER', '15fe69de13253c.png', 'codeegoc', 1, 'Y', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_menu`
--

CREATE TABLE IF NOT EXISTS `tb_menu` (
`id_menu` int(11) NOT NULL,
  `nourut_menu` int(11) DEFAULT NULL,
  `link_menu` varchar(50) DEFAULT NULL,
  `icon_menu` varchar(30) DEFAULT NULL,
  `text_menu` varchar(30) DEFAULT NULL,
  `color_menu` varchar(15) DEFAULT NULL,
  `label_menu` varchar(30) DEFAULT NULL,
  `level_menu` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data untuk tabel `tb_menu`
--

INSERT INTO `tb_menu` (`id_menu`, `nourut_menu`, `link_menu`, `icon_menu`, `text_menu`, `color_menu`, `label_menu`, `level_menu`) VALUES
(1, 1, '?page=update/profile', 'fa  fa-user', 'PROFILE', 'bg-green', 'new ', 12345),
(2, 2, '?page=update/password', 'fa  fa-key', 'CHANGE PASSWORD', 'bg-blue', 'new', 12345),
(3, 3, '?page=insert/menu ', 'fa  fa-firefox', 'SETTING MENU ', 'bg-blue', 'new', 1),
(4, 4, '?page=update/ta   ', 'fa fa-balance-scale', 'SETTING PERIODE', 'bg-blue', 'new', 12),
(6, 5, '?page=insert/config', 'fa fa-registered', 'SET WEBSITE', 'bg-yellow', 'new', 12),
(7, 99, '../keluar.php    ', 'fa fa-sign-out', 'LOGOUT', 'bg-green', 'out', 12345),
(8, 6, '?page=insert/photo', 'fa fa-commenting', 'UPLOAD PHOTO', 'bg-blue', 'new', 12345),
(9, 7, '?page=insert/admin', 'fa fa-500px', 'ADD ADMINISTRATOR', 'bg-yellow', 'new', 1),
(11, 9, '?page=informasi/view', 'fa fa-comment', 'INFORMASI', 'bg-blue', 'new', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_photo`
--

CREATE TABLE IF NOT EXISTS `tb_photo` (
`id_photo` int(11) NOT NULL,
  `pemilik_photo` int(11) NOT NULL,
  `images_photo` varchar(60) NOT NULL,
  `waktuawal_photo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tanggal_photo` date NOT NULL,
  `ct_photo` datetime NOT NULL,
  `ut_photo` datetime NOT NULL,
  `rt_photo` datetime NOT NULL,
  `cb_photo` int(11) NOT NULL,
  `ub_photo` int(11) NOT NULL,
  `rb_photo` int(11) NOT NULL,
  `active_photo` enum('Y','N') NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `tb_photo`
--

INSERT INTO `tb_photo` (`id_photo`, `pemilik_photo`, `images_photo`, `waktuawal_photo`, `tanggal_photo`, `ct_photo`, `ut_photo`, `rt_photo`, `cb_photo`, `ub_photo`, `rb_photo`, `active_photo`) VALUES
(1, 14, '145f7193cd38f7f.png', '2020-09-27 17:42:05', '2020-09-28', '2020-09-28 14:42:05', '2020-09-28 14:42:05', '2020-09-28 14:42:05', 14, 0, 0, 'Y'),
(6, 2, '2628967fb70d3e.png', '2022-05-21 22:30:19', '2022-05-22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 0, 0, 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_riwayat_login`
--

CREATE TABLE IF NOT EXISTS `tb_riwayat_login` (
`id_login` int(11) NOT NULL,
  `username_login` varchar(10) NOT NULL,
  `password_login` varchar(10) NOT NULL,
  `status_login` enum('Y','N') NOT NULL,
  `added_login` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=162 ;

--
-- Dumping data untuk tabel `tb_riwayat_login`
--

INSERT INTO `tb_riwayat_login` (`id_login`, `username_login`, `password_login`, `status_login`, `added_login`) VALUES
(122, 'admin', '123123*', 'Y', 1643254519),
(123, 'admin', '123123*', 'Y', 1643258713),
(124, 'admin', '123123*', 'Y', 1653142006),
(125, 'codeego', '12345123*', 'Y', 1653142298),
(126, 'ghalihinz', '12345123*', 'Y', 1653142392),
(127, 'admin', '123123*', 'Y', 1653144609),
(128, 'ghalihinz', '12345123*', 'Y', 1653144691),
(129, 'admin', '123123*', 'Y', 1653144749),
(130, 'admin', '123123*', 'Y', 1653145050),
(131, 'admin', '123123*', 'Y', 1653172135),
(132, 'sudir', '1234527911', 'N', 1653172792),
(133, 'sudir', '1234523738', 'N', 1653172797),
(134, 'kasir', '123123*', 'Y', 1653172802),
(135, 'ghalihinz', 'akun111115', 'N', 1653172851),
(136, 'admin', '123123*', 'Y', 1653172861),
(137, 'admin', '123123*', 'Y', 1653178222),
(138, 'admin', '123123*', 'Y', 1653179488),
(139, 'admin', '123123*', 'Y', 1653180276),
(140, 'admin', '123123*', 'Y', 1653209235),
(141, 'admin', '123123*', 'Y', 1653217753),
(142, 'admin', '123123*', 'Y', 1653267809),
(143, 'admin', '123123*', 'Y', 1653287538),
(144, 'admin', '123123*', 'Y', 1653305295),
(145, 'admin', '123123*', 'Y', 1653393664),
(146, 'admin', '123123*', 'Y', 1653455970),
(147, 'admin', '123123*', 'Y', 1653465336),
(148, 'ghalihinz', 'akun111163', 'N', 1653472990),
(149, 'ghalihinz', '12345123*', 'Y', 1653472996),
(150, 'sudir', '1234515984', 'N', 1653473016),
(151, 'admin', '123123*', 'Y', 1653473025),
(152, 'sudir', '123123*', 'Y', 1653473057),
(153, 'sudir', '123123*', 'Y', 1653473064),
(154, 'kasir', '123123*', 'Y', 1653473248),
(155, 'kasir', '123123*', 'Y', 1653473258),
(156, 'admin', '123123*', 'Y', 1653473261),
(157, 'kasir', '12345123*', 'Y', 1653473281),
(158, 'kasir', '12345123*', 'Y', 1653473299),
(159, 'admin', '123123*', 'Y', 1653473349),
(160, 'admin', '123123*', 'Y', 1653519821),
(161, 'Admin', '123123*', 'Y', 1653519846);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_ta`
--

CREATE TABLE IF NOT EXISTS `tb_ta` (
`id_ta` int(11) NOT NULL,
  `kode_ta` varchar(5) NOT NULL,
  `nama_ta` varchar(25) NOT NULL,
  `ket_ta` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tb_ta`
--

INSERT INTO `tb_ta` (`id_ta`, `kode_ta`, `nama_ta`, `ket_ta`) VALUES
(1, '2022', 'TA. 2022', 'TAHUN PERIODE 2022');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksidetail`
--

CREATE TABLE IF NOT EXISTS `transaksidetail` (
`id` int(11) NOT NULL,
  `faktur` varchar(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kode` varchar(15) NOT NULL,
  `nama` varchar(100) DEFAULT NULL COMMENT 'Mencatat Nama Produk sebelumnya',
  `harga` double NOT NULL,
  `hargadasar` double NOT NULL,
  `diskon` double unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `addby` int(11) NOT NULL,
  `stt` enum('Y','N') NOT NULL,
  `periode` varchar(5) NOT NULL,
  `admintd` varchar(30) DEFAULT NULL COMMENT 'Mencatat Nama Admin'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksitemp`
--

CREATE TABLE IF NOT EXISTS `transaksitemp` (
`id` int(11) NOT NULL,
  `faktur` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `kode` varchar(15) NOT NULL,
  `nama` varchar(100) DEFAULT NULL COMMENT 'Mencatat Nama Produk sebelumnya',
  `harga` double NOT NULL,
  `hargadasar` double NOT NULL,
  `diskon` double unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `addby` int(11) NOT NULL,
  `admintt` varchar(30) DEFAULT NULL,
  `stt` enum('Y','N') NOT NULL,
  `periode` varchar(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_asset`
--
CREATE TABLE IF NOT EXISTS `view_asset` (
`total_produk` decimal(32,0)
,`modal` double
,`laba` double
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_potongan`
--
CREATE TABLE IF NOT EXISTS `view_potongan` (
`potongan` double
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_login`
--
CREATE TABLE IF NOT EXISTS `vw_login` (
`ID` int(11)
,`Login` varchar(10)
,`Password` varchar(50)
,`Level` int(11)
,`Nama` varchar(60)
,`Key` varchar(50)
);
-- --------------------------------------------------------

--
-- Struktur untuk view `view_asset`
--
DROP TABLE IF EXISTS `view_asset`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_asset` AS select sum(`produk`.`stok`) AS `total_produk`,(`produk`.`hargadasar` * `produk`.`stok`) AS `modal`,((`produk`.`hargajual` - `produk`.`hargadasar`) * `produk`.`stok`) AS `laba` from `produk` group by `produk`.`idproduk`;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_potongan`
--
DROP TABLE IF EXISTS `view_potongan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_potongan` AS select sum(`transaksidetail`.`diskon`) AS `potongan` from `transaksidetail` group by `transaksidetail`.`id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `vw_login`
--
DROP TABLE IF EXISTS `vw_login`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_login` AS select `tb_admin`.`id_admin` AS `ID`,`tb_admin`.`Login` AS `Login`,`tb_admin`.`Password` AS `Password`,`tb_admin`.`Level` AS `Level`,`tb_admin`.`nama_admin` AS `Nama`,`tb_admin`.`key_admin` AS `Key` from `tb_admin` where (`tb_admin`.`active_admin` = 'Y') union all select `tb_master`.`id_master` AS `ID`,`tb_master`.`Login` AS `Login`,`tb_master`.`Password` AS `Password`,`tb_master`.`Level` AS `Level`,`tb_master`.`nama_master` AS `Nama`,`tb_master`.`key_master` AS `Key` from `tb_master` where (`tb_master`.`active_master` = 'Y') union all select `kassa`.`id_kassa` AS `ID`,`kassa`.`user_kassa` AS `Login`,`kassa`.`pwd_kassa` AS `Password`,`kassa`.`level_kassa` AS `Level`,`kassa`.`nama_kassa` AS `Nama`,`kassa`.`key_kassa` AS `Key` from `kassa` where (`kassa`.`status_kassa` = 'Y') order by `Login`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_delete`
--
ALTER TABLE `activity_delete`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_update`
--
ALTER TABLE `activity_update`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barcode`
--
ALTER TABLE `barcode`
 ADD PRIMARY KEY (`id_barcode`), ADD UNIQUE KEY `barcode` (`barcode`);

--
-- Indexes for table `faktur`
--
ALTER TABLE `faktur`
 ADD PRIMARY KEY (`idfaktur`), ADD UNIQUE KEY `kodefaktur` (`kodefaktur`);

--
-- Indexes for table `harga`
--
ALTER TABLE `harga`
 ADD PRIMARY KEY (`idharga`), ADD KEY `kodeproduk` (`kodeproduk`);

--
-- Indexes for table `kassa`
--
ALTER TABLE `kassa`
 ADD PRIMARY KEY (`id_kassa`), ADD UNIQUE KEY `user_kassa` (`user_kassa`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
 ADD PRIMARY KEY (`idkategori`), ADD UNIQUE KEY `namakategori` (`namakategori`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
 ADD PRIMARY KEY (`idperiode`), ADD UNIQUE KEY `kodeperiode` (`kodeperiode`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
 ADD PRIMARY KEY (`idproduk`), ADD UNIQUE KEY `kodeproduk` (`kodeproduk`), ADD KEY `kategori` (`kategori`);

--
-- Indexes for table `returnproduk`
--
ALTER TABLE `returnproduk`
 ADD PRIMARY KEY (`id_return`), ADD KEY `asalfaktur` (`asalfaktur`), ADD KEY `produkreturn` (`produkreturn`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
 ADD PRIMARY KEY (`id_stok`), ADD KEY `produkID` (`produkID`), ADD KEY `barcode` (`barcode`);

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
 ADD PRIMARY KEY (`id_admin`), ADD UNIQUE KEY `user_admin` (`Login`,`key_admin`), ADD KEY `cabang_id` (`cabang_id`);

--
-- Indexes for table `tb_config`
--
ALTER TABLE `tb_config`
 ADD PRIMARY KEY (`id_config`);

--
-- Indexes for table `tb_master`
--
ALTER TABLE `tb_master`
 ADD PRIMARY KEY (`id_master`), ADD UNIQUE KEY `user_master` (`Login`,`key_master`), ADD KEY `cabang_id` (`cabang_id`);

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
 ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `tb_photo`
--
ALTER TABLE `tb_photo`
 ADD PRIMARY KEY (`id_photo`);

--
-- Indexes for table `tb_riwayat_login`
--
ALTER TABLE `tb_riwayat_login`
 ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `tb_ta`
--
ALTER TABLE `tb_ta`
 ADD PRIMARY KEY (`id_ta`);

--
-- Indexes for table `transaksidetail`
--
ALTER TABLE `transaksidetail`
 ADD PRIMARY KEY (`id`), ADD KEY `kode` (`kode`), ADD KEY `faktur` (`faktur`), ADD KEY `addby` (`addby`);

--
-- Indexes for table `transaksitemp`
--
ALTER TABLE `transaksitemp`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_delete`
--
ALTER TABLE `activity_delete`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `activity_update`
--
ALTER TABLE `activity_update`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `barcode`
--
ALTER TABLE `barcode`
MODIFY `id_barcode` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faktur`
--
ALTER TABLE `faktur`
MODIFY `idfaktur` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `harga`
--
ALTER TABLE `harga`
MODIFY `idharga` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kassa`
--
ALTER TABLE `kassa`
MODIFY `id_kassa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
MODIFY `idperiode` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `returnproduk`
--
ALTER TABLE `returnproduk`
MODIFY `id_return` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_config`
--
ALTER TABLE `tb_config`
MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_master`
--
ALTER TABLE `tb_master`
MODIFY `id_master` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_menu`
--
ALTER TABLE `tb_menu`
MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tb_photo`
--
ALTER TABLE `tb_photo`
MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_riwayat_login`
--
ALTER TABLE `tb_riwayat_login`
MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=162;
--
-- AUTO_INCREMENT for table `tb_ta`
--
ALTER TABLE `tb_ta`
MODIFY `id_ta` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transaksidetail`
--
ALTER TABLE `transaksidetail`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transaksitemp`
--
ALTER TABLE `transaksitemp`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `harga`
--
ALTER TABLE `harga`
ADD CONSTRAINT `harga_ibfk_1` FOREIGN KEY (`kodeproduk`) REFERENCES `produk` (`kodeproduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`idkategori`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `returnproduk`
--
ALTER TABLE `returnproduk`
ADD CONSTRAINT `returnproduk_ibfk_1` FOREIGN KEY (`produkreturn`) REFERENCES `produk` (`kodeproduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stok`
--
ALTER TABLE `stok`
ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`barcode`) REFERENCES `produk` (`kodeproduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksidetail`
--
ALTER TABLE `transaksidetail`
ADD CONSTRAINT `transaksidetail_ibfk_1` FOREIGN KEY (`faktur`) REFERENCES `faktur` (`kodefaktur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
