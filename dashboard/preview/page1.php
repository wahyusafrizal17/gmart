<?php
// Include koneksi.php terlebih dahulu untuk mendapatkan fungsi GetSQLValueString
if (file_exists('../../Connections/koneksi.php')) {
    require_once('../../Connections/koneksi.php');
} elseif (file_exists('../Connections/koneksi.php')) {
    require_once('../Connections/koneksi.php');
} elseif (file_exists('Connections/koneksi.php')) {
    require_once('Connections/koneksi.php');
}

$currentPage = $_SERVER["PHP_SELF"];

// Optimasi pagination - kurangi jumlah data per halaman untuk performa lebih baik
$maxRows_Penjualan = 10;
$pageNum_Penjualan = 0;
if (isset($_GET['pageNum_Penjualan'])) {
	$pageNum_Penjualan = $_GET['pageNum_Penjualan'];
}
$startRow_Penjualan = $pageNum_Penjualan * $maxRows_Penjualan;
$jenisbayar = 0;
$colname = 0;
$tgl1 = $tglsekarang;
$tgl2 = $tglsekarang;
$kat = 0;

// Perbaikan logika filtering - tambahkan kondisi untuk kategori
if (isset($_GET['jenisbayar']) && isset($_GET['kasir']) && isset($_GET['tgl1']) && isset($_GET['tgl2']) && isset($_GET['kategori']) && ($_GET['kategori'] != 0)) {
	$jenisbayar = $_GET['jenisbayar'];
	$colname = $_GET['kasir'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	$kat = $_GET['kategori'];
	
	if ($jenisbayar == "0") {
		// Query yang dioptimasi dengan LIMIT untuk performa lebih baik
		$query_Penjualan = sprintf(
			"SELECT DISTINCT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, 
			(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS totalbelanja,
			a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan 
			FROM faktur a 
			WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			ORDER BY a.idfaktur DESC",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);

		$query_total = sprintf(
			"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date")
		);

		//total pendapatan - query yang dioptimasi
		$query_Pendapatan = sprintf(
			"SELECT SUM(totalbelanja) AS pendapatan FROM (
				SELECT DISTINCT a.kodefaktur,
				(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS totalbelanja
				FROM faktur a 
				WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
				AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			) AS subquery",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);

		$query_Laba = sprintf(
			"SELECT SUM(laba) AS laba FROM (
				SELECT DISTINCT a.kodefaktur,
				(SELECT SUM(((b2.harga * b2.qty) - (b2.hargadasar * b2.qty)) - b2.diskon) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS laba
				FROM faktur a 
				WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
				AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			) AS subquery",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);
	} else {
		$query_Penjualan = sprintf(
			"SELECT DISTINCT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, 
			(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS totalbelanja,
			a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan 
			FROM faktur a 
			WHERE a.jenisbayar = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			ORDER BY a.idfaktur DESC",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($jenisbayar, "text"),
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);

		$query_total = sprintf(
			"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date")
		);

		//total pendapatan
		$query_Pendapatan = sprintf(
			"SELECT SUM(totalbelanja) AS pendapatan FROM (
				SELECT DISTINCT a.kodefaktur,
				(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS totalbelanja
				FROM faktur a 
				WHERE a.jenisbayar = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
				AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			) AS subquery",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($jenisbayar, "text"),
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);

		$query_Laba = sprintf(
			"SELECT SUM(laba) AS laba FROM (
				SELECT DISTINCT a.kodefaktur,
				(SELECT SUM(((b2.harga * b2.qty) - (b2.hargadasar * b2.qty)) - b2.diskon) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS laba
				FROM faktur a 
				WHERE a.jenisbayar = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
				AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			) AS subquery",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($jenisbayar, "text"),
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);
	}

	//echo "<script>alert('ini tanggal kasir jenis bayar');</script>";
} elseif (isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$colname = $_GET['kasir'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	//mysqli_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf(
		"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
		GetSQLValueString($colname, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	//total pendapatan
	$query_Pendapatan = sprintf(
		"SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s ORDER BY idfaktur DESC",
		GetSQLValueString($colname, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text")
	);
	//echo "<script>alert('ini tanggal kasir');</script>";
} elseif (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	//mysqli_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf(
		"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur
		WHERE periode = %s AND tglfaktur BETWEEN %s AND %s  ORDER BY idfaktur DESC",
		GetSQLValueString($ta, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);
	//echo "<script>alert('ini tanggal');</script>";
	//total pendapatan
	$query_Pendapatan = sprintf(
		"SELECT  SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE periode = %s AND tglfaktur BETWEEN %s AND %s  ORDER BY idfaktur DESC",
		GetSQLValueString($ta, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_Laba = sprintf(
		"SELECT SUM(((harga * qty) - (hargadasar * qty)) - diskon) AS laba
		FROM transaksidetail
		WHERE faktur IN (SELECT kodefaktur FROM faktur WHERE periode = %s AND tglfaktur BETWEEN %s AND %s AND statusfaktur = 'Y')",
		GetSQLValueString($ta, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);
} else {
	//mysqli_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf(
		"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur
		WHERE periode = %s ORDER BY idfaktur DESC",
		GetSQLValueString($ta, "text")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);
	//echo "<script>alert('ini default');</script>";
	//total pendapatan
	$query_Pendapatan = sprintf(
		"SELECT  SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE periode = %s ORDER BY idfaktur DESC",
		GetSQLValueString($ta, "text")
	);

	$query_Laba = sprintf(
		"SELECT SUM(((harga * qty) - (hargadasar * qty)) - diskon) AS laba
		FROM transaksidetail
		WHERE faktur IN (SELECT kodefaktur FROM faktur WHERE periode = %s AND statusfaktur = 'Y')",
		GetSQLValueString($ta, "text")
	);
}

$query_limit_Penjualan = sprintf("%s LIMIT %d, %d", $query_Penjualan, $startRow_Penjualan, $maxRows_Penjualan);

// Kembalikan ke logika pagination yang sederhana dan aman
if (isset($_GET['totalRows_Penjualan'])) {
	$totalRows_Penjualan = $_GET['totalRows_Penjualan'];
} else {
	$all_Penjualan = mysqli_query($koneksi, $query_Penjualan);
	$totalRows_Penjualan = mysqli_num_rows($all_Penjualan);
}

$totalPages_Penjualan = ceil($totalRows_Penjualan / $maxRows_Penjualan) - 1;

$queryString_Penjualan = "";
if (!empty($_SERVER['QUERY_STRING'])) {
	$params = array();
	parse_str($_SERVER['QUERY_STRING'], $params);
	unset($params['pageNum_Penjualan']);
	$queryString_Penjualan = '&' . http_build_query($params);
}

$rs_Penjualan = mysqli_query($koneksi, $query_limit_Penjualan) or die(mysqli_error($koneksi));
$row_Penjualan = mysqli_fetch_assoc($rs_Penjualan);

$Total = mysqli_query($koneksi, $query_total) or die(mysqli_error($koneksi));
$row_Total = mysqli_fetch_assoc($Total);

$Pendapatan = mysqli_query($koneksi, $query_Pendapatan) or die(mysqli_error($koneksi));
$row_Pendapatan = mysqli_fetch_assoc($Pendapatan);

$Laba = mysqli_query($koneksi, $query_Laba) or die(mysqli_error($koneksi));
$row_Laba = mysqli_fetch_assoc($Laba);

$Faktur = mysqli_query($koneksi, "SELECT DISTINCT jenisbayar FROM faktur WHERE periode = '$ta' ORDER BY jenisbayar") or die(mysqli_error($koneksi));
$row_Faktur = mysqli_fetch_assoc($Faktur);

$Kassa = mysqli_query($koneksi, "SELECT * FROM vw_login WHERE periode = '$ta' ORDER BY Nama") or die(mysqli_error($koneksi));
$row_Kassa = mysqli_fetch_assoc($Kassa);

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY namakategori") or die(mysqli_error($koneksi));
$row_kategori = mysqli_fetch_assoc($kategori);
?> 