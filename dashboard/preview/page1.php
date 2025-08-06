<?php
$currentPage = $_SERVER["PHP_SELF"];

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

if (isset($_GET['jenisbayar']) && ($_GET['jenisbayar'] != "") && isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2']) && isset($_GET['kategori']) && ($_GET['kategori'] != 0)) {
	$jenisbayar = $_GET['jenisbayar'];
	if ($jenisbayar == "0") {
		$colname = $_GET['kasir'];
		$tgl1 = $_GET['tgl1'];
		$tgl2 = $_GET['tgl2'];
		$kat = $_GET['kategori'];
		
		$query_Penjualan = sprintf(
			"SELECT DISTINCT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, 
			(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS totalbelanja,
			a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan 
			FROM faktur a 
			WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.addbyfaktur = %s AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			ORDER BY a.idfaktur DESC",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($colname, "text"),
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
				WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.addbyfaktur = %s AND a.periode = %s 
				AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			) AS subquery",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($colname, "text"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);

		$query_Laba = sprintf(
			"SELECT SUM(laba) AS laba FROM (
				SELECT DISTINCT a.kodefaktur,
				(SELECT SUM(((b2.harga * b2.qty) - (b2.hargadasar * b2.qty)) - b2.diskon) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS laba
				FROM faktur a 
				WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.addbyfaktur = %s AND a.periode = %s 
				AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			) AS subquery",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($colname, "text"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);
	} else {
		$colname = $_GET['kasir'];
		$tgl1 = $_GET['tgl1'];
		$tgl2 = $_GET['tgl2'];
		$kat = $_GET['kategori'];
		$jenisbayar = $_GET['jenisbayar'];
		
		$query_Penjualan = sprintf(
			"SELECT DISTINCT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, 
			(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS totalbelanja,
			a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan 
			FROM faktur a 
			WHERE a.jenisbayar = %s AND a.addbyfaktur = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			ORDER BY a.idfaktur DESC",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($jenisbayar, "text"),
			GetSQLValueString($colname, "text"),
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
				WHERE a.jenisbayar = %s AND a.addbyfaktur = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
				AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			) AS subquery",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($jenisbayar, "text"),
			GetSQLValueString($colname, "text"),
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
				WHERE a.jenisbayar = %s AND a.addbyfaktur = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
				AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
			) AS subquery",
			GetSQLValueString($kat, 'text'),
			GetSQLValueString($jenisbayar, "text"),
			GetSQLValueString($colname, "text"),
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
} elseif(isset($_GET['kategori']) && ($_GET['kategori'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2']) && (!isset($_GET['kasir']) || $_GET['kasir'] == 0) && (!isset($_GET['jenisbayar']) || $_GET['jenisbayar'] == "")) {
	$kat = $_GET['kategori'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	//mysqli_select_db($database_koneksi, $koneksi);

	$query_Penjualan = sprintf(
		"SELECT DISTINCT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, 
		(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS totalbelanja,
		a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan 
		FROM faktur a 
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
		AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		ORDER BY a.idfaktur DESC",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
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
			WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		) AS subquery",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
	);

	$query_Laba = sprintf(
		"SELECT SUM(laba) AS laba FROM (
			SELECT DISTINCT a.kodefaktur,
			(SELECT SUM(((b2.harga * b2.qty) - (b2.hargadasar * b2.qty)) - b2.diskon) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS laba
			FROM faktur a 
			WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		) AS subquery",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
	);
} elseif(isset($_GET['kategori']) && ($_GET['kategori'] != 0) && isset($_GET['jenisbayar']) && ($_GET['jenisbayar'] != "") && isset($_GET['tgl1']) && isset($_GET['tgl2']) && (!isset($_GET['kasir']) || $_GET['kasir'] == 0)) {
	$kat = $_GET['kategori'];
	$jenisbayar = $_GET['jenisbayar'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];

	$query_Penjualan = sprintf(
		"SELECT DISTINCT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, 
		(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS totalbelanja,
		a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan 
		FROM faktur a 
		WHERE a.jenisbayar = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
		AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		ORDER BY a.idfaktur DESC",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($jenisbayar, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
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
		GetSQLValueString($kat, "text"),
		GetSQLValueString($jenisbayar, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
	);

	$query_Laba = sprintf(
		"SELECT SUM(laba) AS laba FROM (
			SELECT DISTINCT a.kodefaktur,
			(SELECT SUM(((b2.harga * b2.qty) - (b2.hargadasar * b2.qty)) - b2.diskon) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS laba
			FROM faktur a 
			WHERE a.jenisbayar = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		) AS subquery",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($jenisbayar, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
	);
} elseif(isset($_GET['kategori']) && ($_GET['kategori'] != 0) && isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['jenisbayar']) && ($_GET['jenisbayar'] != "") && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$kat = $_GET['kategori'];
	$colname = $_GET['kasir'];
	$jenisbayar = $_GET['jenisbayar'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];

	$query_Penjualan = sprintf(
		"SELECT DISTINCT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, 
		(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS totalbelanja,
		a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan 
		FROM faktur a 
		WHERE a.jenisbayar = %s AND a.addbyfaktur = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
		AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		ORDER BY a.idfaktur DESC",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($jenisbayar, "text"),
		GetSQLValueString($colname, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
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
			WHERE a.jenisbayar = %s AND a.addbyfaktur = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		) AS subquery",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($jenisbayar, "text"),
		GetSQLValueString($colname, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
	);

	$query_Laba = sprintf(
		"SELECT SUM(laba) AS laba FROM (
			SELECT DISTINCT a.kodefaktur,
			(SELECT SUM(((b2.harga * b2.qty) - (b2.hargadasar * b2.qty)) - b2.diskon) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS laba
			FROM faktur a 
			WHERE a.jenisbayar = %s AND a.addbyfaktur = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		) AS subquery",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($jenisbayar, "text"),
		GetSQLValueString($colname, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
	);
} elseif(isset($_GET['kategori']) && ($_GET['kategori'] != 0) && isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2']) && (!isset($_GET['jenisbayar']) || $_GET['jenisbayar'] == "")) {
	$kat = $_GET['kategori'];
	$colname = $_GET['kasir'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];

	$query_Penjualan = sprintf(
		"SELECT DISTINCT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, 
		(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS totalbelanja,
		a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan 
		FROM faktur a 
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.addbyfaktur = %s AND a.periode = %s 
		AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		ORDER BY a.idfaktur DESC",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($colname, "text"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
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
			WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.addbyfaktur = %s AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		) AS subquery",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($colname, "text"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
	);

	$query_Laba = sprintf(
		"SELECT SUM(laba) AS laba FROM (
			SELECT DISTINCT a.kodefaktur,
			(SELECT SUM(((b2.harga * b2.qty) - (b2.hargadasar * b2.qty)) - b2.diskon) FROM transaksidetail b2 INNER JOIN produk c2 ON b2.nama = c2.namaproduk WHERE b2.faktur = a.kodefaktur AND c2.kategori = %s) AS laba
			FROM faktur a 
			WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.addbyfaktur = %s AND a.periode = %s 
			AND EXISTS (SELECT 1 FROM transaksidetail b INNER JOIN produk c ON b.nama = c.namaproduk WHERE b.faktur = a.kodefaktur AND c.kategori = %s)
		) AS subquery",
		GetSQLValueString($kat, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($colname, "text"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
	);
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
		INNER JOIN faktur ON transaksidetail.faktur = faktur.kodefaktur
		WHERE tglfaktur BETWEEN %s AND %s",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);
} else {
	//mysqli_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf(
		"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur
		WHERE tglfaktur BETWEEN %s AND %s ORDER BY idfaktur DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_Pendapatan = sprintf(
		"SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE tglfaktur BETWEEN %s AND %s ORDER BY idfaktur DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_Laba = sprintf(
		"SELECT SUM(((harga * qty) - (hargadasar * qty)) - diskon) AS laba 
		FROM transaksidetail
		INNER JOIN faktur ON transaksidetail.faktur = faktur.kodefaktur
		WHERE tglfaktur BETWEEN %s AND %s",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);
}
$query_limit_Penjualan = sprintf("%s LIMIT %d, %d", $query_Penjualan, $startRow_Penjualan, $maxRows_Penjualan);
$rs_Penjualan = mysqli_query($koneksi, $query_limit_Penjualan) or die(mysqli_error($koneksi));
$row_Penjualan = mysqli_fetch_assoc($rs_Penjualan);

$rs_total = mysqli_query($koneksi, $query_total) or die(mysqli_error($koneksi));
$row_Total = mysqli_fetch_assoc($rs_total);

$rs_pendapatan = mysqli_query($koneksi, $query_Pendapatan) or die(mysqli_error($koneksi));
$row_Pendapatan = mysqli_fetch_assoc($rs_pendapatan);

if (!isset($query_Laba) || empty($query_Laba)) {
    // Prevent fatal error if $query_Laba is not set
    $query_Laba = "SELECT 0 AS laba";
}
$rs_laba = mysqli_query($koneksi, $query_Laba) or die(mysqli_error($koneksi));
$row_Laba = mysqli_fetch_assoc($rs_laba);

//kasir
$query_Kasir = sprintf(
	"SELECT DISTINCT(`addbyfaktur`) as id, vw_login.Nama FROM faktur
		LEFT JOIN vw_login ON addbyfaktur = ID
		WHERE periode = %s ORDER BY idfaktur DESC",
	GetSQLValueString($ta, "text")
);
$Kassa = mysqli_query($koneksi, $query_Kasir) or die(errorQuery(mysqli_error($koneksi)));
$row_Kassa = mysqli_fetch_assoc($Kassa);
$totalRows_Kassa = mysqli_num_rows($Kassa);
//

//kasir
$query_Faktur = sprintf(
	"SELECT DISTINCT(`jenisbayar`) as jenisbayar FROM faktur
		WHERE periode = %s ORDER BY idfaktur DESC",
	GetSQLValueString($ta, "text")
);
$Faktur = mysqli_query($koneksi, $query_Faktur) or die(errorQuery(mysqli_error($koneksi)));
$row_Faktur = mysqli_fetch_assoc($Faktur);
$totalRows_Faktur = mysqli_num_rows($Faktur);
//--------

//Kategori
$query_kategori = sprintf(
	"SELECT * FROM kategori ORDER BY namakategori ASC"
);
$kategori = mysqli_query($koneksi, $query_kategori) or die(errorQuery(mysqli_error($koneksi)));
$row_kategori = mysqli_fetch_assoc($kategori);

if (isset($_GET['totalRows_Penjualan'])) {
	$totalRows_Penjualan = $_GET['totalRows_Penjualan'];
} else {
	$all_Penjualan = mysqli_query($koneksi, $query_Penjualan);
	$totalRows_Penjualan = mysqli_num_rows($all_Penjualan);
}
$totalPages_Penjualan = ceil($totalRows_Penjualan / $maxRows_Penjualan) - 1;

$queryString_Penjualan = "";
if (!empty($_SERVER['QUERY_STRING'])) {
	$params = explode("&", $_SERVER['QUERY_STRING']);
	$newParams = array();
	foreach ($params as $param) {
		if (
			stristr($param, "pageNum_Penjualan") == false &&
			stristr($param, "totalRows_Penjualan") == false
		) {
			array_push($newParams, $param);
		}
	}
	if (count($newParams) != 0) {
		$queryString_Penjualan = "&" . htmlentities(implode("&", $newParams));
	}
}
$queryString_Penjualan = sprintf("&totalRows_Penjualan=%d%s", $totalRows_Penjualan, $queryString_Penjualan);
