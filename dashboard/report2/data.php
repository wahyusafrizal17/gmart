<?php
mysqli_select_db($database_koneksi, $koneksi);
$query_rs_penjualan = sprintf(
	"SELECT SUM(harga * qty) as Jumlah, SUM(qty) as Item,  count(faktur) as Transaksi FROM `transaksidetail` WHERE tanggal = CURDATE() AND periode = %s GROUP BY faktur",
	GetSQLValueString($ta, "text")
);
$rs_penjualan = mysqli_query($query_rs_penjualan, $koneksi) or die(errorQuery(mysqli_errno($koneksi), mysqli_error()));
$row_penjualan = mysqli_fetch_assoc($rs_penjualan);
$totalPenjualan = mysqli_num_rows($rs_penjualan);

mysqli_select_db($database_koneksi, $koneksi);
$query_rs_item = sprintf(
	"SELECT SUM(qty) as Item FROM `transaksidetail` WHERE tanggal = CURDATE() AND periode = %s",
	GetSQLValueString($ta, "text")
);
$rs_item = mysqli_query($query_rs_item, $koneksi) or die(errorQuery(mysqli_errno($koneksi), mysqli_error()));
$row_item = mysqli_fetch_assoc($rs_item);
$totalitem = mysqli_num_rows($rs_item);

mysqli_select_db($database_koneksi, $koneksi);
$query_rs_return = sprintf(
	"SELECT SUM(qtyreturn) as Jumlah FROM `returnproduk` WHERE tglreturn = CURDATE() AND periode = %s",
	GetSQLValueString($ta, "text")
);
$rs_return = mysqli_query($query_rs_return, $koneksi) or die(errorQuery(mysqli_errno($koneksi), mysqli_error()));
$row_return = mysqli_fetch_assoc($rs_return);
$totalreturn = mysqli_num_rows($rs_return);

mysqli_select_db($database_koneksi, $koneksi);
$query_rs_pengeluaran = "SELECT SUM(nominal) as Jumlah FROM `pengeluaran` WHERE tgl = CURDATE()";
$rs_pengeluaran = mysqli_query($query_rs_pengeluaran, $koneksi) or die(errorQuery(mysqli_errno($koneksi), mysqli_error()));
$row_pengeluaran = mysqli_fetch_assoc($rs_pengeluaran);
$totalpengeluaran = mysqli_num_rows($rs_pengeluaran);


mysqli_select_db($database_koneksi, $koneksi);
$query_rs_pendapatan = sprintf(
	"SELECT SUM(harga * qty) as TotalHarga, tglfaktur FROM `transaksidetail` LEFT JOIN faktur ON faktur = kodefaktur WHERE statusfaktur = 'Y' AND faktur.periode = %s AND tglfaktur = CURDATE() GROUP BY tglfaktur",
	GetSQLValueString($ta, "text")
);
$rs_pendapatan = mysqli_query($query_rs_pendapatan, $koneksi) or die(errorQuery(mysqli_errno($koneksi), mysqli_error()));
$row_pendapatan = mysqli_fetch_assoc($rs_pendapatan);
$totalpendapatan = mysqli_num_rows($rs_pendapatan);
