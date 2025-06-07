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

if (isset($_GET['jenisbayar']) && ($_GET['jenisbayar'] != "") && isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$jenisbayar = $_GET['jenisbayar'];
	if ($jenisbayar == "0") {
		$colname = $_GET['kasir'];
		$tgl1 = $_GET['tgl1'];
		$tgl2 = $_GET['tgl2'];
		//mysqli_select_db($database_koneksi, $koneksi);
		$query_Penjualan = sprintf(
			"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur 
		WHERE (tglfaktur BETWEEN %s AND %s) AND statusfaktur = 'Y' AND  addbyfaktur = %s AND  faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
			GetSQLValueString($koneksi, $tgl1, "date"),
			GetSQLValueString($koneksi, $tgl2, "date"),
			GetSQLValueString($koneksi, $colname, "text"),
			GetSQLValueString($koneksi, $ta, "text")
		);

		$query_total = sprintf(
			"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
			GetSQLValueString($koneksi, $tgl1, "date"),
			GetSQLValueString($koneksi, $tgl2, "date")
		);

		//total pendapatan
		$query_Pendapatan = sprintf(
			"SELECT SUM(totalbayar - kembalian) AS `pendapatan`  FROM faktur 
		WHERE (tglfaktur BETWEEN %s AND %s) AND statusfaktur = 'Y' AND  addbyfaktur = %s AND  faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
			GetSQLValueString($koneksi, $tgl1, "date"),
			GetSQLValueString($koneksi, $tgl2, "date"),
			GetSQLValueString($koneksi, $colname, "text"),
			GetSQLValueString($koneksi, $ta, "text")
		);
	} else {
		$colname = $_GET['kasir'];
		$tgl1 = $_GET['tgl1'];
		$tgl2 = $_GET['tgl2'];
		//mysqli_select_db($database_koneksi, $koneksi);
		$query_Penjualan = sprintf(
			"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur 
		WHERE statusfaktur = 'Y' AND jenisbayar = %s AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
			GetSQLValueString($koneksi, $jenisbayar, "text"),
			GetSQLValueString($koneksi, $colname, "text"),
			GetSQLValueString($koneksi, $tgl1, "date"),
			GetSQLValueString($koneksi, $tgl2, "date"),
			GetSQLValueString($koneksi, $ta, "text")
		);

		$query_total = sprintf(
			"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
			GetSQLValueString($koneksi, $tgl1, "date"),
			GetSQLValueString($koneksi, $tgl2, "date")
		);

		//total pendapatan
		$query_Pendapatan =
			sprintf(
				"SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur 
		WHERE statusfaktur = 'Y' AND jenisbayar = %s AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
				GetSQLValueString($koneksi, $jenisbayar, "text"),
				GetSQLValueString($koneksi, $colname, "text"),
				GetSQLValueString($koneksi, $tgl1, "date"),
				GetSQLValueString($koneksi, $tgl2, "date"),
				GetSQLValueString($koneksi, $ta, "text")
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
		GetSQLValueString($koneksi, $colname, "text"),
		GetSQLValueString($koneksi, $tgl1, "date"),
		GetSQLValueString($koneksi, $tgl2, "date"),
		GetSQLValueString($koneksi, $ta, "text")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($koneksi, $tgl1, "date"),
		GetSQLValueString($koneksi, $tgl2, "date")
	);

	//total pendapatan
	$query_Pendapatan = sprintf(
		"SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
		GetSQLValueString($koneksi, $colname, "text"),
		GetSQLValueString($koneksi, $tgl1, "date"),
		GetSQLValueString($koneksi, $tgl2, "date"),
		GetSQLValueString($koneksi, $ta, "text")
	);
	//echo "<script>alert('ini tanggal kasir');</script>";
} elseif (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	//mysqli_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf(
		"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur
		WHERE periode = %s AND tglfaktur BETWEEN %s AND %s  ORDER BY idfaktur DESC",
		GetSQLValueString($koneksi, $ta, "text"),
		GetSQLValueString($koneksi, $tgl1, "date"),
		GetSQLValueString($koneksi, $tgl2, "date")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($koneksi, $tgl1, "date"),
		GetSQLValueString($koneksi, $tgl2, "date")
	);
	//echo "<script>alert('ini tanggal');</script>";
	//total pendapatan
	$query_Pendapatan = sprintf(
		"SELECT  SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE periode = %s AND tglfaktur BETWEEN %s AND %s  ORDER BY idfaktur DESC",
		GetSQLValueString($koneksi, $ta, "text"),
		GetSQLValueString($koneksi, $tgl1, "date"),
		GetSQLValueString($koneksi, $tgl2, "date")
	);
} else {
	//mysqli_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf(
		"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur
		WHERE tglfaktur BETWEEN %s AND %s ORDER BY idfaktur DESC",
		GetSQLValueString($koneksi, $tgl1, "date"),
		GetSQLValueString($koneksi, $tgl2, "date")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($koneksi, $tgl1, "date"),
		GetSQLValueString($koneksi, $tgl2, "date")
	);

	$query_Pendapatan = sprintf(
		"SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE tglfaktur BETWEEN %s AND %s ORDER BY idfaktur DESC",
		GetSQLValueString($koneksi, $tgl1, "date"),
		GetSQLValueString($koneksi, $tgl2, "date")
	);
}
$query_limit_Penjualan = sprintf("%s LIMIT %d, %d", $query_Penjualan, $startRow_Penjualan, $maxRows_Penjualan);
$rs_Penjualan = mysqli_query($koneksi, $query_limit_Penjualan) or die(errorQuery(mysqli_errno($koneksi), mysqli_error($koneksi)));
$row_Penjualan = mysqli_fetch_assoc($rs_Penjualan);

$rs_total = mysqli_query($koneksi, $query_total) or die(errorQuery(mysqli_errno($koneksi), mysqli_error($koneksi)));
$row_Total = mysqli_fetch_assoc($rs_total);

$rs_pendapatan = mysqli_query($koneksi, $query_Pendapatan) or die(errorQuery(mysqli_errno($koneksi), mysqli_error($koneksi)));
$row_Pendapatan = mysqli_fetch_assoc($rs_pendapatan);

//kasir
$query_Kasir = sprintf(
	"SELECT DISTINCT(`addbyfaktur`) as id, vw_login.Nama FROM faktur
		LEFT JOIN vw_login ON addbyfaktur = ID
		WHERE periode = %s ORDER BY idfaktur DESC",
	GetSQLValueString($koneksi, $ta, "text")
);
$Kassa = mysqli_query($koneksi, $query_Kasir) or die(errorQuery(mysqli_error($koneksi)));
$row_Kassa = mysqli_fetch_assoc($Kassa);
$totalRows_Kassa = mysqli_num_rows($Kassa);
//

//kasir
$query_Faktur = sprintf(
	"SELECT DISTINCT(`jenisbayar`) as jenisbayar FROM faktur
		WHERE periode = %s ORDER BY idfaktur DESC",
	GetSQLValueString($koneksi, $ta, "text")
);
$Faktur = mysqli_query($koneksi, $query_Faktur) or die(errorQuery(mysqli_error($koneksi)));
$row_Faktur = mysqli_fetch_assoc($Faktur);
$totalRows_Faktur = mysqli_num_rows($Faktur);
//--------


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
