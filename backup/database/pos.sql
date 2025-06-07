-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2022 at 09:31 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_delete`
--

CREATE TABLE IF NOT EXISTS `activity_delete` (
`id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `oleh` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_update`
--

CREATE TABLE IF NOT EXISTS `activity_update` (
`id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `oleh` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `barcode`
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
-- Table structure for table `faktur`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Triggers `faktur`
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
-- Table structure for table `harga`
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
-- Table structure for table `kassa`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `kassa`
--

INSERT INTO `kassa` (`id_kassa`, `user_kassa`, `pwd_kassa`, `nama_kassa`, `alamat_kassa`, `telp_kassa`, `level_kassa`, `status_kassa`, `added_kassa`, `updated_kassa`, `addby_kassa`, `key_kassa`) VALUES
(8, 'auliya', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'Auliya', 'KISARAN', '089637818489', 3, 'Y', 1642681857, 1657430537, 2, 'viewpr4t4m4'),
(9, 'aira', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'Aira', '-', '089818852274', 3, 'Y', 1654228697, 0, 2, 'viewpr4t4m4'),
(10, 'aira iz', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'aira iz', 'Kisaran', '081231231', 3, 'Y', 1657429613, 0, 2, 'viewpr4t4m4');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
`idkategori` int(11) NOT NULL,
  `namakategori` varchar(30) NOT NULL,
  `ketkategori` varchar(100) DEFAULT NULL,
  `addedkategori` int(11) NOT NULL DEFAULT '123',
  `updatedkategori` int(11) NOT NULL,
  `addbykategori` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`, `ketkategori`, `addedkategori`, `updatedkategori`, `addbykategori`) VALUES
(99, 'LAINNYA', NULL, 1642825009, 1657182335, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE IF NOT EXISTS `pengeluaran` (
`id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `judul` varchar(255) NOT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `oleh` varchar(100) DEFAULT NULL,
  `createdat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nominal` double unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran_histori`
--

CREATE TABLE IF NOT EXISTS `pengeluaran_histori` (
`id` int(11) NOT NULL,
  `judulawal` varchar(255) NOT NULL,
  `judulbaru` varchar(255) NOT NULL,
  `nominalawal` double NOT NULL,
  `nominalbaru` double NOT NULL,
  `tercatat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `oleh` varchar(100) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='riwayat perubahan pengeluaran' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE IF NOT EXISTS `periode` (
`idperiode` int(11) NOT NULL,
  `kodeperiode` varchar(5) NOT NULL,
  `ketperiode` varchar(30) NOT NULL,
  `sttperiode` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

-- --------------------------------------------------------

--
-- Table structure for table `returnproduk`
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
-- Table structure for table `stok`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Mencatat Perubahan Stok Barang' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
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
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `Login`, `Password`, `nama_admin`, `gender_admin`, `address_admin`, `email_admin`, `hp_admin`, `photo_admin`, `Level`, `active_admin`, `waktuawal_admin`, `key_admin`, `cabang_id`) VALUES
(2, 'admin', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'ADMINISTRATOR', 'L', 'JL SUDIRMAN NO.66', 'codeegoc@gmail.com', '089637818489', '26031b740bdbe9.jpg', 2, 'Y', '2021-02-17 08:19:10', 'admin123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_config`
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
-- Dumping data for table `tb_config`
--

INSERT INTO `tb_config` (`id_config`, `title`, `deskripsi`, `header`, `footer`, `text1`, `text2`, `text3`) VALUES
(1, 'MYTOKO', 'www.yoursite.com', 'KASIR', 'codeego', 'Jl. Sudirman. No.215 Tanjungbalai - Sumatera Utara Indonesia<br>No. HP: 089637818489', '- Terima Kasih -', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tb_import`
--

CREATE TABLE IF NOT EXISTS `tb_import` (
`id` int(11) NOT NULL,
  `kodeproduk` varchar(255) NOT NULL,
  `namaproduk` varchar(255) NOT NULL,
  `hargamodal` varchar(255) NOT NULL,
  `hargajual` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `stok` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `minstok` varchar(255) DEFAULT NULL,
  `addby` int(2) NOT NULL COMMENT 'oleh',
  `addat` int(15) NOT NULL COMMENT 'waktu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_master`
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
-- Dumping data for table `tb_master`
--

INSERT INTO `tb_master` (`id_master`, `Login`, `Password`, `nama_master`, `photo_master`, `key_master`, `Level`, `active_master`, `cabang_id`) VALUES
(1, 'codeego', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'Administrator', '15fe69de13253c.png', 'codeegoc', 1, 'Y', 12);

-- --------------------------------------------------------

--
-- Table structure for table `tb_menu`
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
-- Dumping data for table `tb_menu`
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
-- Table structure for table `tb_photo`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tb_photo`
--

INSERT INTO `tb_photo` (`id_photo`, `pemilik_photo`, `images_photo`, `waktuawal_photo`, `tanggal_photo`, `ct_photo`, `ut_photo`, `rt_photo`, `cb_photo`, `ub_photo`, `rb_photo`, `active_photo`) VALUES
(1, 14, '145f7193cd38f7f.png', '2020-09-27 17:42:05', '2020-09-28', '2020-09-28 14:42:05', '2020-09-28 14:42:05', '2020-09-28 14:42:05', 14, 0, 0, 'Y'),
(5, 2, '26031b740bdbe9.jpg', '2021-02-21 01:28:32', '2021-02-21', '2021-02-21 08:28:32', '2021-02-21 08:28:32', '2021-02-21 08:28:32', 2, 0, 0, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tb_riwayat_login`
--

CREATE TABLE IF NOT EXISTS `tb_riwayat_login` (
`id_login` int(11) NOT NULL,
  `username_login` varchar(10) NOT NULL,
  `password_login` varchar(10) NOT NULL,
  `status_login` enum('Y','N') NOT NULL,
  `added_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ta`
--

CREATE TABLE IF NOT EXISTS `tb_ta` (
`id_ta` int(11) NOT NULL,
  `kode_ta` varchar(5) NOT NULL,
  `nama_ta` varchar(25) NOT NULL,
  `ket_ta` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_ta`
--

INSERT INTO `tb_ta` (`id_ta`, `kode_ta`, `nama_ta`, `ket_ta`) VALUES
(1, '2022', 'TA. 2022', 'TAHUN PERIODE 2022');

-- --------------------------------------------------------

--
-- Table structure for table `transaksidetail`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaksitemp`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
-- Structure for view `view_asset`
--
DROP TABLE IF EXISTS `view_asset`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_asset`  AS  select sum(`produk`.`stok`) AS `total_produk`,(`produk`.`hargadasar` * `produk`.`stok`) AS `modal`,((`produk`.`hargajual` - `produk`.`hargadasar`) * `produk`.`stok`) AS `laba` from `produk` group by `produk`.`idproduk` ;

-- --------------------------------------------------------

--
-- Structure for view `view_potongan`
--
DROP TABLE IF EXISTS `view_potongan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_potongan` AS select sum(`transaksidetail`.`diskon`) AS `potongan` from `transaksidetail` group by `transaksidetail`.`id`;

-- --------------------------------------------------------

--
-- Structure for view `vw_login`
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
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluaran_histori`
--
ALTER TABLE `pengeluaran_histori`
 ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tb_import`
--
ALTER TABLE `tb_import`
 ADD PRIMARY KEY (`id`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `activity_update`
--
ALTER TABLE `activity_update`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `barcode`
--
ALTER TABLE `barcode`
MODIFY `id_barcode` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faktur`
--
ALTER TABLE `faktur`
MODIFY `idfaktur` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `harga`
--
ALTER TABLE `harga`
MODIFY `idharga` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kassa`
--
ALTER TABLE `kassa`
MODIFY `id_kassa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pengeluaran_histori`
--
ALTER TABLE `pengeluaran_histori`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
MODIFY `idperiode` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `returnproduk`
--
ALTER TABLE `returnproduk`
MODIFY `id_return` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `tb_import`
--
ALTER TABLE `tb_import`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tb_riwayat_login`
--
ALTER TABLE `tb_riwayat_login`
MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_ta`
--
ALTER TABLE `tb_ta`
MODIFY `id_ta` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transaksidetail`
--
ALTER TABLE `transaksidetail`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaksitemp`
--
ALTER TABLE `transaksitemp`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `harga`
--
ALTER TABLE `harga`
ADD CONSTRAINT `harga_ibfk_1` FOREIGN KEY (`kodeproduk`) REFERENCES `produk` (`kodeproduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`idkategori`) ON UPDATE CASCADE;

--
-- Constraints for table `returnproduk`
--
ALTER TABLE `returnproduk`
ADD CONSTRAINT `returnproduk_ibfk_1` FOREIGN KEY (`produkreturn`) REFERENCES `produk` (`kodeproduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stok`
--
ALTER TABLE `stok`
ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`barcode`) REFERENCES `produk` (`kodeproduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksidetail`
--
ALTER TABLE `transaksidetail`
ADD CONSTRAINT `transaksidetail_ibfk_1` FOREIGN KEY (`faktur`) REFERENCES `faktur` (`kodefaktur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
