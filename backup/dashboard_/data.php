<?php
mysql_select_db($database_koneksi, $koneksi);
$query_rs_penjualan = sprintf(
	"SELECT SUM(harga * qty) as Jumlah, SUM(qty) as Item,  count(faktur) as Transaksi FROM `transaksidetail` WHERE tanggal = CURDATE() AND periode = %s GROUP BY faktur",
	GetSQLValueString($ta, "text")
);
$rs_penjualan = mysql_query($query_rs_penjualan, $koneksi) or die(errorQuery(mysql_errno($koneksi), mysql_error()));
$row_penjualan = mysql_fetch_assoc($rs_penjualan);
$totalPenjualan = mysql_num_rows($rs_penjualan);

mysql_select_db($database_koneksi, $koneksi);
$query_rs_item = sprintf(
	"SELECT SUM(qty) as Item FROM `transaksidetail` WHERE tanggal = CURDATE() AND periode = %s",
	GetSQLValueString($ta, "text")
);
$rs_item = mysql_query($query_rs_item, $koneksi) or die(errorQuery(mysql_errno($koneksi), mysql_error()));
$row_item = mysql_fetch_assoc($rs_item);
$totalitem = mysql_num_rows($rs_item);

mysql_select_db($database_koneksi, $koneksi);
$query_rs_return = sprintf(
	"SELECT SUM(qtyreturn) as Jumlah FROM `returnproduk` WHERE tglreturn = CURDATE() AND periode = %s",
	GetSQLValueString($ta, "text")
);
$rs_return = mysql_query($query_rs_return, $koneksi) or die(errorQuery(mysql_errno($koneksi), mysql_error()));
$row_return = mysql_fetch_assoc($rs_return);
$totalreturn = mysql_num_rows($rs_return);

mysql_select_db($database_koneksi, $koneksi);
$query_rs_pengeluaran = "SELECT SUM(nominal) as Jumlah FROM `pengeluaran` WHERE tgl = CURDATE()";
$rs_pengeluaran = mysql_query($query_rs_pengeluaran, $koneksi) or die(errorQuery(mysql_errno($koneksi), mysql_error()));
$row_pengeluaran = mysql_fetch_assoc($rs_pengeluaran);
$totalpengeluaran = mysql_num_rows($rs_pengeluaran);


mysql_select_db($database_koneksi, $koneksi);
$query_rs_pendapatan = sprintf(
	"SELECT SUM(harga * qty) as TotalHarga, tglfaktur FROM `transaksidetail` LEFT JOIN faktur ON faktur = kodefaktur WHERE statusfaktur = 'Y' AND faktur.periode = %s AND tglfaktur = CURDATE() GROUP BY tglfaktur",
	GetSQLValueString($ta, "text")
);
$rs_pendapatan = mysql_query($query_rs_pendapatan, $koneksi) or die(errorQuery(mysql_errno($koneksi), mysql_error()));
$row_pendapatan = mysql_fetch_assoc($rs_pendapatan);
$totalpendapatan = mysql_num_rows($rs_pendapatan);
